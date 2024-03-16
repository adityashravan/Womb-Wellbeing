import numpy as np
from flask import Flask, render_template, request, redirect
import pickle

app = Flask(__name__)

model = pickle.load(open('model.pkl','rb'))
@app.route('/')
def home():
    return render_template('hn.html')

@app.route('/predict',methods=['GET','POST'])
def predict():
    #int_features = [float(x) for x in request.form.values()]
    int_features = []
    for value in request.form.values():
        try:
            float_value = float(value)
            int_features.append(float_value)
        except ValueError:
            # Handle non-numeric or empty string values
            pass
    final_features = [np.array(int_features)]
    prediction = model.predict(final_features)
    output = prediction[0]
    if output == 1:
        output='Normal'
    elif output == 2:
        output='Suspect'
    else:
        output='Pathological'
    return render_template('hn.html',prediction_text='The fetus condition as predicted by the model should be {}'.format(output))


def predict_api():
    data=request.get_json(force=True)
    prediction=model.predict([np.array(list(data.values()))])
    output=prediction[0]
    if output == 1:
        output='Normal'
    elif output == 2:
        output='Suspect'
    else:
        output='Pathological'



    return jsonify(output)

if __name__ == '__main__':
    app.run(debug=True)