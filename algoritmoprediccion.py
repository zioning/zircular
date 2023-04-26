#!/usr/bin/env python
import mysql.connector as sql
db_connection = sql.connect(host='54.94.124.199', database='admin_iot', user='admin_iot', password='75543ZIONING')
db_cursor = db_connection.cursor()
db_cursor.execute('SELECT data_volts1,data_corriente1,data_volts2,data_corriente2,data_volts3,data_corriente3,data_kw3,data_frecuencia,data_kg,data_fpt,data_thdv1,data_thdv2,data_thdv3,data_thdi1,data_thdi2,data_thdi3,data_cn  FROM alucol ORDER BY data_id DESC LIMIT 1500')

table_rows = db_cursor.fetchall()
import pandas as pd
data = pd.DataFrame(table_rows)
db_cursor.close()
db_connection.close()
data.shape
data.columns = ['voltaje1', 'corriente1','voltaje2', 'corriente2','voltaje3', 'corriente3','kw3','frecuencia','kg','factor','thdv1','thdv2','thdv3','thdi1','thdi2','thdi3','cn']
import xgboost as xgb
import numpy as np
from pandas import datetime
import seaborn as sns
from sklearn.model_selection import train_test_split, GridSearchCV, RandomizedSearchCV
from xgboost.sklearn import XGBRegressor # wrapper
X=data[['voltaje1', 'corriente1','voltaje2', 'corriente2','voltaje3', 'corriente3','frecuencia','kg','factor','thdv1','thdv2','thdv3','thdi1','thdi2','thdi3','cn']]
y=data['kw3']
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.3, # 30% for the evaluation set
                                            random_state = 42)
# evaluation metric: rmspe
# Root Mean Square Percentage Error
# code chunk shared at Kaggle
def rmspe(y, yhat):
    return np.sqrt(np.mean((yhat / y-1) ** 2))

def rmspe_xg(yhat, y):
    y = np.expm1(y.get_label())
    yhat = np.expm1(yhat)
    return "rmspe", rmspe(y, yhat)
params = {
    'booster': 'gbtree',
    'objective': 'reg:squarederror', # regression task
    'subsample': 0.8, # 80% of data to grow trees and prevent overfitting
    'colsample_bytree': 0.85, # 85% of features used
    'eta': 0.1,
    'max_depth': 10,
    'seed': 42} # for reproducible results

# XGB with xgboost library
dtrain = xgb.DMatrix(X_train[['voltaje1', 'corriente1','voltaje2', 'corriente2','voltaje3', 'corriente3','frecuencia','kg','factor','thdv1','thdv2','thdv3','thdi1','thdi2','thdi3','cn']], y_train)
dtest = xgb.DMatrix(X_test[['voltaje1', 'corriente1','voltaje2', 'corriente2','voltaje3', 'corriente3','frecuencia','kg','factor','thdv1','thdv2','thdv3','thdi1','thdi2','thdi3','cn']], y_test)

watchlist = [(dtrain, 'train'), (dtest, 'test')]

xgb_model = xgb.train(params, dtrain, 100, evals = watchlist,
                      early_stopping_rounds = 50, feval = rmspe_xg, verbose_eval = True)

# XGB with sklearn wrapper
# the same parameters as for xgboost model
params_sk = {'max_depth': 10,
            'n_estimators': 100, # the same as num_rounds in xgboost
            'objective': 'reg:squarederror',
            'subsample': 0.8,
            'colsample_bytree': 0.85,
            'learning_rate': 0.1,
            'seed': 42}

skrg = XGBRegressor(**params_sk)

skrg.fit(X_train, y_train,eval_set=[(X_train, y_train),
                    (X_test, y_test)])
results = skrg.evals_result()
#results
#results = skrg.evals_result()
epochs = len(results['validation_0']['rmse'])
epochs = len(results['validation_1']['rmse'])
#x_axis = range(0, epochs)
 #import scipy.stats as st
params_grid = {
    'learning_rate': [0.01,0.02,0.03,0.04, 0.05,0.06,0.07,0.08,0.09,0.1,0.2,0.3,0.4],
    'max_depth': [5,6,7,8,9,10,11,12,13,14,16],
    'gamma': [0.1,0.2,0.3,0.4,0.6,0.8,1],
    'reg_alpha': [19,20,21,22,23]
}

search_sk = RandomizedSearchCV(skrg, params_grid, cv = 5) # 5 fold cross validation
search_sk.fit(X_train, y_train)

# best parameters
# print(search_sk.best_params_); print(search_sk.best_score_)
# with new parameters
params_new = {
    'booster': 'gbtree',
    'objective': 'reg:squarederror',
    'subsample': 0.7,
    'colsample_bytree': 0.7,
    'eta': 0.08,
    'max_depth': 7,
    'gamma': 1,
    'reg_alpha': 23,
    'seed': 42}

model_final = xgb.train(params_new, dtrain, 130, evals = watchlist,
                        early_stopping_rounds = 50, feval = rmspe_xg, verbose_eval = True)
yhat = model_final.predict(xgb.DMatrix(X_test[['voltaje1', 'corriente1','voltaje2', 'corriente2','voltaje3', 'corriente3','frecuencia','kg','factor','thdv1','thdv2','thdv3','thdi1','thdi2','thdi3','cn']]))
len(yhat)
X_test.shape
#print(X_test.columns)
david=pd.DataFrame(yhat,y_test)
david.columns =['Prediccion']
david['costolineabase']=david.index
#david.reset_index(drop=True)
#print(david.shape)
david['lineabase']=david.costolineabase / 10
david['costolinea']=david.lineabase *400
david['prereal']=david.Prediccion / 10
david['ahorro']=david.prereal * 400

def MAE(prediction,true_values):
    return np.mean(                                                      # Mean
                np.abs(                                                   # Absolute
                        prediction-true_values                            # Error
                    )
                )
###############################################################################################
def RMSE(prediction,true_values):

    return np.sqrt(                                                          # Root
            np.mean(                                                      # Mean
                np.square(                                                # Squared
                         prediction-true_values                           # Error
                )
            )
        )
##############################################################################################3
def MAPE(prediction,true_value):
    return np.mean(                                           # Mean
        np.abs(                                               # Absolute
               (prediction-true_value)/true_value             # Error
            )*100                                            # Percentage
    )
for i,row in david.iterrows():
        #print(row['Prediccion'],row['costolineabase (Real)'])
        db_connection = sql.connect(host='54.94.124.199', database='admin_iot', user='admin_iot', password='75543ZIONING')
        add_employee = ("INSERT INTO prediccioncosto(prediccion, costolineabase, ahorro, lineabase,prereal,costolinea) VALUES (%s, %s, %s, %s, %s, %s)")
        db_cursor = db_connection.cursor()
        db_cursor.execute(add_employee, tuple([float((row['Prediccion'])),float(row['costolineabase']),float(row['ahorro']),float(row['lineabase']),float(row['prereal']),float(row['costolinea'])]))
        #db_connection.escape_string(data_employee)
print("Record inserted")
# Make sure data is committed to the database
db_connection.commit()
db_cursor.close()
db_connection.close()
