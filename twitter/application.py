from twitterscraper import query_tweets
import json
from pprint import pprint
import datetime as dt
from flask import Flask
from flask import request, render_template
#app=Flask(__name__)

import detectflood

team_tags = {"Floods":['flood', 'water', ], "Cyclone": {'Cyclone', 'Orissa'}}

def get_tweets(tag):
	out = dict()
	for i, tweet in enumerate(query_tweets(tag, 10,begindate=dt.date.today() - dt.timedelta(1), enddate=dt.date.today())):
		out[i] = {'id':tweet.id, 'like':tweet.likes, 'replies':tweet.replies, 'retweets': tweet.retweets, 'text':tweet.text, 'timestamp':str(tweet.timestamp), 'user':tweet.user}
	#pprint(out)
	with open("json/"+tag.strip('#')+".json", 'w') as f:
		json.dump(out, f, indent = 4)
	return 'ok'
def parse(tag):
	parsed = dict()
	with open("json/"+tag.strip('#')+".json", "r") as f:
		parsed = json.load(f)
	return parsed
	
def imp_tweets(parsed):
	imp = list()
	for tweet in parsed.values():

		
		if(detectflood.analysetweet(tweet)):
			imp.append(tweet)
	return imp
	
def dump(tweets):
	with open("imp/"+list(tweets.keys())[0]+".json", 'w+') as f:
		json.dump(tweets, f, indent = 4)
	return 'ok'

#def score(file_name):
#	imp_tweet_list = list()
#	with open('imp/'+file_name, 'r') as f:
#		imp_tweet_list = list(json.load(f).values())[0]
	
def hello():
	tag_list = ["#floods"]
	for t in tag_list:
		ok=get_tweets(t)
		parsed = parse(t)
		imp_tweet_list = {t: imp_tweets(parsed)}
		#imp_tweet_list={"#flood":["hello","hi"]}
		#print(imp_tweet_list)
		o=dump(imp_tweet_list)
	for i in imp_tweet_list["#floods"]:
		pprint(str(i['text']))

	


if __name__ == '__main__':
	hello()
#@app.route('/')

	

	#score_dict = score('#IPL.json') 
	#count = dict()
	#for tweet in imp_tweet_list:
	#	for team, tags in team_tags.items():
	#		for tag in tags:
	#			if(tag.lower() in tweet['text'].lower()):
	#				count[team] = count.get(team, 0) + 1
	#				break
	#return count
	
	
	
	
	