from twitterscraper import query_tweets
import json
from pprint import pprint

team_tags = {"Floods":['flood', 'water', ], "Cyclone": {'Cyclone', 'Orissa'}}

def get_tweets(tag):
	out = dict()
	for i, tweet in enumerate(query_tweets(tag, 10000)):
		out[i] = {'id':tweet.id, 'like':tweet.likes, 'replies':tweet.replies, 'retweets': tweet.retweets, 'text':tweet.text, 'timestamp':str(tweet.timestamp), 'user':tweet.user}
	pprint(out)
	with open("json/"+tag.strip('#')+".json", 'w') as f:
		json.dump(out, f, indent = 4)
		
def parse(tag):
	parsed = dict()
	with open("json/"+tag.strip('#')+".json", "r") as f:
		parsed = json.load(f)
	return parsed
	
def imp_tweets(parsed):
	imp = list()
	for tweet in parsed.values():
		if(int(tweet['like']) > 20 or int(tweet['retweets']) > 10):
			imp.append(tweet)
	return imp
	
def dump(tweets):
	with open("imp/"+list(tweets.keys())[0]+".json", 'w+') as f:
		json.dump(tweets, f, indent = 4)

#def score(file_name):
#	imp_tweet_list = list()
#	with open('imp/'+file_name, 'r') as f:
#		imp_tweet_list = list(json.load(f).values())[0]
	
	


if __name__ == '__main__':
	tag_list = ["#kerala","#flood" ,"#floods","#cyclone","#help","#floodrelief","#floodwarning","#earthquake"]
	for t in tag_list:
		get_tweets(t)
		parsed = parse(t)
		imp_tweet_list = {t: imp_tweets(parsed)}
		dump(imp_tweet_list)
	
	#score_dict = score('#IPL.json') 
	#count = dict()
	#for tweet in imp_tweet_list:
	#	for team, tags in team_tags.items():
	#		for tag in tags:
	#			if(tag.lower() in tweet['text'].lower()):
	#				count[team] = count.get(team, 0) + 1
	#				break
	#return count
	
	
	
	
	