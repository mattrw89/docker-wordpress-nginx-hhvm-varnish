#!/bin/python

import urllib2
import json

response = urllib2.urlopen('http://api.wordpress.org/core/version-check/1.7/')

wp_json_resp = json.load(response)

wp_json_resp_version = wp_json_resp['offers'][0]['version']

print wp_json_resp_version