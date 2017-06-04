import sqlite3
db = sqlite3.connect("../data/challengerDatabase")

cursor = db.cursor()
print("are you sure you want to wipe challengerDatabase? (y/n)")
confirm = raw_input();

if confirm == "y":
	tables = ["userMetadata", "challengeMetadata", "likeRecords", "rechallengeRecords", "followRecords", "acceptanceRecords", "videoLikeRecords", "feedData"]
	for table in tables:
		print("deleting from " + table + "...")
		cursor.execute("DELETE FROM " + table + ";")
	db.commit()
	db.close()
	print("database clear")

