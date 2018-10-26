from __future__ import print_function

import os
os.environ["THEANO_FLAGS"] = "mode=FAST_RUN,device=gpu,floatX=float32"


import numpy as np
import matplotlib.pyplot as plt
import pandas
import math


from keras.models import Sequential
from keras.layers import Dense
from keras.layers import LSTM
from sklearn.preprocessing import MinMaxScaler


# In[ ]:


# fix random seed for reproducibility
np.random.seed(10)


# In[ ]:


#Use the flood_data.csv dataset
dataframe = pandas.read_csv('dataset/flood_train.csv', usecols=[1], engine='python', skipfooter=3)
dataset   = dataframe.values
dataset   = dataset.astype('float32')
dataframe.head()


# In[ ]:


# normalize the dataset
scaler  = MinMaxScaler(feature_range=(0, 1))
dataset = scaler.fit_transform(dataset)


# In[ ]:


# split into train and test sets
train_size  = int(len(dataset) * 0.67)
test_size   = len(dataset) - train_size
train, test = dataset[0:train_size,:], dataset[train_size:len(dataset),:]


# In[ ]:


# This function creates a sliding window of the dataset.
def create_dataset(dataset, sliding_window=1):
    dataX, dataY = [], []
    for i in range(len(dataset)-sliding_window-1):
        a = dataset[i:(i+sliding_window), 0]
        dataX.append(a)
        dataY.append(dataset[i + sliding_window, 0])
    return np.array(dataX), np.array(dataY)


# In[ ]:


# use a n-10 sliding window equivalent to 2.5 hours of historical data
slide_window   = 10
trainX, trainY = create_dataset(train, slide_window)
testX, testY   = create_dataset(test, slide_window)


# In[ ]:


trainX = np.reshape(trainX, (trainX.shape[0], 1, trainX.shape[1]))
testX  = np.reshape(testX, (testX.shape[0], 1, testX.shape[1]))


# In[ ]:


#Setup the LSTM

model = Sequential()
model.add(LSTM(4, input_dim=slide_window))
#model.add(LSTM(4, input_shape=(None, 10)))
model.add(Dense(1))
model.compile(loss='mean_squared_error', optimizer='adam')
model.fit(trainX, trainY, nb_epoch=1, batch_size=1, verbose=2)


# In[17]:


'''import numpy as np
import matplotlib.pyplot as plt
import pandas
import math
from sklearn.preprocessing import MinMaxScaler

# Test the network on an unseen data
unseen = pandas.read_csv('Dataset/flood_test.csv',sep=',')
unseen.head()
unseen_test = unseen['waterlevel'].values

unseen_clean = []
for i in unseen_test:
    unseen_clean.append([i])
unseen_clean = np.asarray(unseen_clean).astype('float32')
unseen_clean = scaler.fit_transform(unseen_clean)

features,labels = create_dataset(unseen_clean, slide_window)
features        = np.reshape(features, (109186,1, 10))

print(features)
print(unseen_clean)

import random
random_number = round(random.uniform(0, 1),2)
print(random_number)
unseen_clean = []
unseen_clean.append([random_number])
unseen_clean = np.asarray(unseen_clean).astype('float32')
print(unseen_clean)'''


# In[ ]:


#test real time fake data

import random
import time

prediction = []

while (True):
    my_list=[]
    for i in range(1,20):
        random_number = round(random.uniform(0, 1),2)#random number to simulate real time waterlevel
        my_list.append([random_number])
    
    unseen_clean = my_list
    #unseen_clean.append(my_list)

    print(my_list)
    #print(unseen_clean)
    unseen_clean = np.asarray(my_list).astype('float32')
    unseen_clean = scaler.fit_transform(unseen_clean)
    
    features,labels = create_dataset(unseen_clean, slide_window)
    #print(features)
    #features = np.reshape(features, (109186,1, 10))
    features = np.reshape(features, (features.shape[0], 1, 10))
    unseen_results = model.predict(features)
    
    prediction.append(unseen_results)
    print(unseen_results)
    #plt.gca().set_ylim(bottom=0)
    #plt.gca().set_ylim(top=1)

    print('-------------------- Predicted --------------------')
    #plt.plot(prediction)
    #plt.show()
    
    #time.sleep(120) #predicts if flood occurs for every 2 minutes once

