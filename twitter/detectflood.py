########### Python 3.6 #############
import requests


def check(text):
	headers = {
	    # Request headers
	    'Ocp-Apim-Subscription-Key': 'b7f72b006bad41b29c5a326ffad326f4',
	}

	params ={
	    # Query parameter
	    'q': text,
	    # Optional request parameters, set to default values
	    'timezoneOffset': '0',
	    'verbose': 'false',
	    'spellCheck': 'false',
	    'staging': 'false',
	}

	try:
	    r = requests.get('https://westus.api.cognitive.microsoft.com/luis/v2.0/apps/b576cecd-6546-4881-ab22-edad8d363b01',headers=headers, params=params)
	    #print(r)
	    data=r.json()
	    return data['topScoringIntent']['intent']


	except Exception as e:
	    print("error")
	    return "None"

	

def analysetweet(tweet):

	pred=check(tweet['text'])
	#print(tweet['text'])
	#print(pred)
	#print('-------------------')
	#print()
	if pred=='DetectFlood':
		return 1
	else:
		return 0
		

		#flooddatabase.insertintotable(tweet)
		#tweetextract.gettweetbylocation(tweet)

if __name__=='__main__':
	check()
