import sqlite3
import os
db = sqlite3.connect("../data/challengerDatabase")

cursor = db.cursor()
print("are you sure you want to wipe challengerDatabase and all related files? (y/n)")
confirm = raw_input();

if confirm == "y":
	tables = ["userMetadata", "challengeMetadata", "likeRecords", "rechallengeRecords", "followRecords", "acceptanceRecords", "videoLikeRecords", "feedData"]
	for table in tables:
		print("deleting from " + table + "...")
		cursor.execute("DELETE FROM " + table + ";")
	db.commit()
	db.close()
	print("database clear, now moving on to delete uploads and images...")

	for file in os.listdir("/var/www/images"):
		print("deleting file: " + file)
		os.system("sudo rm /var/www/images/" + file)
	for file in os.listdir("/var/www/php/uploads"):
		print("deleting directory: " + file)
		os.system("sudo rm -r /var/www/php/uploads/" + file);

	print("u either did that on purpose or royally messed up")

