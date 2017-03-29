# -- coding: utf-8

require "open-uri" 
require "nokogiri"

rFile = open("account.txt", "r")
wFile = open("result.txt", "a+")

rFile.each_line {|r|
	url = "https://www.instagram.com/" << r
	charset = nil
	html = open(url).read
	doc = Nokogiri::HTML.parse(html)
	followedDom = doc.xpath('//script').text
    match = followedDom.match(/\"followed_by\": {\"count\": (.+?)}/)
    p match[1]
	wFile.write(match[1] << "\t" << r)
}

rFile.close
wFile.close
