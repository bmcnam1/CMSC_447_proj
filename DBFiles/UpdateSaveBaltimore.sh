#delete old csv
sudo -S <<< “password” rm /home/ubuntu/DBFiles/CrimeData.csv;

#download most recent dataset
wget -O /home/ubuntu/DFiles/CrimeData.csv https://data.baltimorecity.gov/api/views/wsfq-mvij/rows.csv?accessType=DOWNLOAD;

#update dataset
python /home/ubuntu/DBFiles/DBUpdate.py /home/ubuntu/DBFiles/CrimeData.csv;

