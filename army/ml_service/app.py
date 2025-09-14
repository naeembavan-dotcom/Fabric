from fastapi import FastAPI
from pydantic import BaseModel
import uvicorn

app = FastAPI()

class PerfQuery(BaseModel):
    fabric_features: dict
    climate_features: dict

class SustQuery(BaseModel):
    fabric_features: dict

@app.get("/health")
def health():
    return {"status": "ok"}

def _mock_perf(f, c):
    # f: fabric_features dict, c: climate_features dict
    weight = float(f.get('weight_g_per_m2', 200))
    breath = float(f.get('breathability_score', 60))
    insulation = float(f.get('insulation_r_value', 0.15))
    tensile = float(f.get('tensile_strength', 300))
    moisture = float(f.get('moisture_absorption', 10))

    temp = float(c.get('avg_temp_c', 25))
    hum = float(c.get('avg_humidity', 50))

    # heuristics
    ins = max(0.01, insulation - max(0, (temp - 20)) * 0.003)
    breathability = max(1, (breath - max(0, (25 - temp)) / 2))
    durability = max(1, tensile / 40)
    moisture_wick = max(0.1, moisture / 5)

    return {
        "insulation": round(ins, 3),
        "breathability": round(breathability, 2),
        "durability": round(durability, 2),
        "moisture_wicking": round(moisture_wick, 2)
    }

@app.post("/predict_performance")
def predict_performance(q: PerfQuery):
    return {"performance": _mock_perf(q.fabric_features, q.climate_features)}

@app.post("/sustainability_score")
def sustainability_score(q: SustQuery):
    ff = q.fabric_features
    score = 50
    if ff.get('recyclable') or ff.get('recyclability', 0) > 50:
        score += 25
    if ff.get('biodegradable'):
        score += 20
    score += min(5, ff.get('recycled_pct', 0) / 10) if ff.get('recycled_pct') else 0
    return {"sustainability_score": round(min(100, score), 2)}

@app.post("/recommend_best")
def recommend_best(payload: dict):
    candidates = payload.get('candidates', [])
    climates = payload.get('climates', [])
    results = []

    for c in candidates:
        perf_sum = 0
        for cl in climates:
            p = _mock_perf(c, cl)
            perf_sum += p['insulation'] + p['breathability'] / 10 + p['durability'] / 10

        perf_avg = perf_sum / max(1, len(climates))

        # Dynamic sustainability score per candidate
        sust = sustainability_score(SustQuery(fabric_features=c))['sustainability_score']

        # Unit cost fallback
        cost = float(c.get('unit_cost', 2.0))

        # Final score formula
        final = perf_avg * 0.6 + (sust / 100) * 0.4 - (cost / 10)

        results.append({
            'fabric': c.get('name', 'unknown'),
            'score': round(final, 3),
            'perf_avg': round(perf_avg, 3),
            'sustainability': sust,
            'unit_cost': cost
        })

    # Sort candidates by final score descending
    results = sorted(results, key=lambda x: x['score'], reverse=True)

    return {'recommendations': results}


if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)
