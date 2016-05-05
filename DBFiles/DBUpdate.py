#File: DBUpdate.py
#purpose: read from csv file and update the dataset;

import sys
import MySQLdb
import re
import datetime
import csv

#open the database with the system's credentials
def open_db():
	try:
		conn = MySQLdb.connect("localhost", "root", "cmsc447", "save_baltimore", port=3306)
		return conn

	except MySQLdb.Error, e:
		print "Cannot connect to database!"
		print str(e)
		sys.exit(2)

#input: CrimeDate, CrimeTime
#output: sql datetime
#notes: when this function is called, any entry with bad dates or times are thrown out
def getCrimeDateTime(CrimeDate, CrimeTime):
	#fix date

	#original: mm/dd/yyyy
	#sql: yyyy-mm-dd
	#substring: [index1:index2+1]
	fixedDate = ""
	yyyy = CrimeDate[6:10]
	mm = CrimeDate[0:2]
	dd = CrimeDate[3:5]
	fixedDate = yyyy+'-'+mm+'-'+dd
	#original: hh:mm:ss OR hhmm
	#sql: hh:mm:ss
	fixedTime = CrimeTime
	
	#yyyy-mm-dd hh:mm:ss
	return fixedDate + " " + fixedTime 

#parameters: whole address
#returns: just the street name
def getStreetName(location):
	#get characters not including the number at the beginning
	#eg, after first space
	streetName = location
	if " " in location:
		streetName = location.split(' ', 1)[1]
	if "#" in location:
		#remove apartment info
		streetName = streetName.split('#')[0]
	if "APT" in location:
		streetName = streetName.split("APT")[0]
	return streetName

#check if a value should evaluate to null
def isNull(var):
	#note: python gives string "None" as null values, but you must insert None entity (not string) as real null value
	if var == 'None' or var.strip() == "": 
		return True
	else:
		return False

#determine if the format of the crimeTime field is good
def isBadTime(time):
	if len(time) != 8:
		return True
	else:
		return False

#determine if the long/lat fields are good
def isBadLocation(location_1):
	#pattern: '(39.__________, -76.__________)'
	#for now, just focused on mathching first two digits (not making sure it's always in Baltimore per se)
	pattern = re.compile("\(39\.\d{10},\s\-76\.\d{10}\)")
	if location_1 =='None':
		#null
		return True
	elif pattern.match(location_1):
		#matches pattern
		return False 
	else:
		#doesn't match pattern
		return True

#extract latitude from lat long
def getLatitude(location_1):
	#original: '(39.__________, -76.__________)'
	return float(location_1[1:13])

#extract longitude from lat long
def getLongitude(location_1):
	#original: '(39.__________, -76.__________)'
	return float(location_1[16:30])

#turn a value into null if it should be a null
def getPossibleNull(var):
	#note: inserting None with python is the equivalent of mysql NULL
	if var == 'None' or var == "":
		return None
	else:
		return var
#main function
def main(argc, argv):
	if argc != 2:
		print 'Usage: '+argv[0] + ' csvfilename'
		sys.exit(2)

	conn = open_db()
	conn.autocommit(True)
	cur = conn.cursor();


	#open csv file
	try:
		csvFile = open(argv[1])
		#delete rows from db
		query = "delete from Baltimore_Crime_Data;"
		cur.execute(query)
		conn.commit()
		
	except IOError:
		print "no file!"
		sys.exit(0)

	#read from the file
	for line in csv.reader(csvFile):
		if line[0] == "CrimeDate":
			continue
		CrimeDate = line[0].strip()
		CrimeTime = line[1].strip()
		Location = line[3].strip()
		CrimeType = line[4].strip()
		Weapon = line[5].strip()
		District = line[7].strip()
		Neighborhood = line[8].strip()
		Location_1 = line[9].strip()
		
		#only add rows with valid info
		if not isNull(Location) and not isBadLocation(Location_1) and not isNull(District) and not isNull(Neighborhood) and not isBadTime(CrimeTime):
				fixedLocation = getPossibleNull(Location)
				fixedWeapon = getPossibleNull(Weapon)
				fixedDateTime = getCrimeDateTime(CrimeDate, CrimeTime)
				StreetName = str(getStreetName(Location))
				Latitude = str(getLatitude(Location_1))
				Longitude = str(getLongitude(Location_1))
				query = "insert into Baltimore_Crime_Data (crimeDateTime, address, streetName, crimeType, weapon, district, neighborhood, latitude, longitude) values (%s, %s, %s, %s, %s, %s, %s, %s, %s);"
				
				#execute query
		 		cur.execute(query,(fixedDateTime, Location, StreetName, CrimeType, fixedWeapon, District, Neighborhood, Latitude, Longitude))
		 		conn.commit()
	print "Fetched all data!"

if __name__ == '__main__':
	main(len(sys.argv), sys.argv)	
