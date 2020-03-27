from flask import Flask, url_for, send_from_directory,render_template, request
from flask_cors import CORS
import logging, os
import datetime
import requests
from werkzeug import secure_filename
from flask_mysqldb import MySQL
from instabot import Bot


app = Flask(__name__)
CORS(app)
##file_handler = logging.FileHandler('server.log')
#app.logger.addHandler(file_handler)
#app.logger.setLevel(logging.INFO)

PROJECT_HOME = os.path.dirname(os.path.realpath(__file__))
UPLOAD_FOLDER = '{}/photo/'.format(PROJECT_HOME)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER




app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'nurchulis'
app.config['MYSQL_PASSWORD'] = 'lina@maulana'
app.config['MYSQL_DB'] = 'robot_ig'
mysql = MySQL(app)


@app.route('/')
def index():
  	return 'Server Works!'
  	
@app.route('/upload_photo', methods = ['POST'])
def say_hello():
    if request.method == "POST":
        details = request.json
        username = details['username']
        password = details['password']
        caption = details['caption']
        photo = details['photo']
        bot = Bot()
        bot.login(username=username, password=password,is_threaded=True)
	##user_id = bot.get_user_id_from_username("lego")
	##user_info = bot.get_user_info(user_id)
	hasil=bot.upload_photo("photo/"+photo, caption=caption)
	return(hasil)

@app.route('/login', methods = ['POST'])
def login():
    if request.method == "POST":
        details = request.form
        username = details['username']
        password = details['password']
        status = '1'
        bot = Bot()
        hajar=bot.login(username=username, password=password,is_threaded=True)
        print(hajar)
        if(hajar==True):
            cursor = mysql.connection.cursor()
            result = cursor.execute("INSERT INTO account(username, password, status) VALUES (%s, %s, %s)", (username, password, status))
            mysql.connection.commit()
            cursor.close()
            return({"status":"success"})
        else:
            return({"status":"failed"})
    return("success")


@app.route('/hapus_account', methods = ['GET'])
def delete_account():
    if request.method == "GET":
        details = request.args
        id_account=details['id_account']
        cursor = mysql.connection.cursor()
        result = cursor.execute("DELETE FROM account WHERE id_account="+id_account)
        mysql.connection.commit()
        cursor.close()
        return({"status":"success","data":id_account})
    return("success")

@app.route('/hapus_posting', methods = ['GET'])
def delete_posting():
    if request.method == "GET":
        details = request.args
        id_posting=details['id_posting']
        cursor = mysql.connection.cursor()
        result = cursor.execute("DELETE FROM posting WHERE id_posting="+id_posting)
        mysql.connection.commit()
        cursor.close()
        return({"status":"success","data":id_posting})
    return("success")




@app.route('/aktifandnon', methods = ['GET'])
def aktifandnon():
    if request.method == "GET":
        details = request.args
        id_account=details['id_account']
        cursor = mysql.connection.cursor()
        status=get_account(id_account)
        result = cursor.execute("UPDATE  account SET status=%s WHERE id_account=%s",(status,id_account))
        mysql.connection.commit()
        cursor.close()
        return({"status":"success","data":id_account})
    return("success")


def get_account(id_account):
    cursor = mysql.connection.cursor()
    result = cursor.execute("SELECT * from account Where id_account="+id_account)
    data = cursor.fetchone()
    if(data[3]=='1'):
        return('0')
    else:
        return('1')

@app.route('/runstop', methods = ['GET'])
def runstop():
    if request.method == "GET":
        details = request.args
        cursor = mysql.connection.cursor()
        status=get_status_running()
        name_settings='mulai_run'
        result = cursor.execute("UPDATE  settings_bot SET status=%s WHERE name_settings=%s",(status,name_settings))
        mysql.connection.commit()
        cursor.close()
        return({"status":"success","data":status})
    return("success")



def get_status_running():
    cursor = mysql.connection.cursor()
    result = cursor.execute("SELECT * from settings_bot Where name_settings='mulai_run'")
    data = cursor.fetchone()
    if(data[2]=='jalan'):
        return('berhenti')
    else:
        return('jalan')

@app.route('/run_start_form', methods = ['POST'])
def run_start_form():
    if request.method == "POST":
        details = request.form
        id_posting = details['id_posting']

        cursor = mysql.connection.cursor()
        status=get_status_running()
        run_update_job(id_posting)
        name_settings='mulai_run'
        result = cursor.execute("UPDATE  settings_bot SET status=%s WHERE name_settings=%s",(status,name_settings))
        
        mysql.connection.commit()
        cursor.close()
        return({"status":"success","data":status})
    return("success")

def run_update_job(id_posting):
    cursor = mysql.connection.cursor()
    status='belum'
    result = cursor.execute("UPDATE job_list SET id_posting=%s, status=%s",(id_posting, status))
    mysql.connection.commit()
    cursor.close()



@app.route('/cron_job_now', methods = ['GET'])
def cron_job_now():
    if request.method == "GET":
        cursor = mysql.connection.cursor()
        result = cursor.execute("SELECT * from settings_bot Where name_settings='mulai_run' LIMIT 1")
        data_s = cursor.fetchone()
        if(data_s[2]=='berhenti'):
            return({"status":"failed",'description':'Bot telah dihentikan'})
        else:
            cursor = mysql.connection.cursor()
            result = cursor.execute("SELECT * from job_list Where status='belum' AND kategori='now' LIMIT 1")
            data = cursor.fetchone()
            #print(data[0])

            if(result):
    	        dataCount={
    	            'id_job':data[0],
    	            'id_account':data[1],
    	            'id_posting':data[2],
    	            'kategori':data[3],
    	            'schedule_at':data[4]        
    	        }
    	        #---Get Data Account------#
    	        id_account=data[1]
    	        status='1'
    	        get_account = cursor.execute("SELECT * from account Where id_account= %s AND status= %s",(id_account,status))
    	        data_account = cursor.fetchone()
    	        print(data_account[1])

    	        #---Get Data Posting------#
    	        id_posting=data[2]
    	        status='1'
    	        get_posting = cursor.execute("SELECT * from posting Where id_posting= %s AND status= %s",(id_posting,status))
    	        data_posting = cursor.fetchone()
    	        print(data_posting[3])

            	username=data_account[1]
            	password=data_account[2]
            	caption=data_posting[1]
            	photo=data_posting[2]

            	hajar = requests.post("http://127.0.0.1:5000/upload_photo", json={'username':username,'password':password,'caption':caption,'photo':photo})
            	hasil_hajar=hajar.json()
            	status=(hasil_hajar['status'])
            	if(status=='success'):
            		print(data[0])
            		update_status_job_list(data[0])
            		kategori='now'
            		insert_log_job(data[1],kategori)
            		print('success lur')
            	else:
      				print('gagal lur')
            	return ({'success':'true','data':dataCount})
            else:
                runstop()
                return {'success':'false', 'description':'Semua Joblist Telah Selesai'}

            details = request.json
            username = details['username']
            password = details['password']
            hasil=username
	return(hasil)

def update_status_job_list(id_job):
	cursor = mysql.connection.cursor()
	status = 'selesai'
	result = cursor.execute('UPDATE job_list SET status = %s WHERE id_job = %s',(status,id_job))
	mysql.connection.commit()
	cursor.close()
	if(result):
		return {'success':'true'}
	else:
		return {'success':'false'}

def insert_log_job(id_account,kategori):
	cursor = mysql.connection.cursor()
	status = 'success'
	created_at = datetime.datetime.now()
	result = cursor.execute("INSERT INTO log_job(id_account, status, kategori, created_at) VALUES (%s, %s, %s, %s)", (id_account, status, kategori, created_at))
	mysql.connection.commit()
	cursor.close()
	return ({"status":"success"})

def insert_log_job_selesai(id_account,kategori):
    cursor = mysql.connection.cursor()
    status = 'Semua Data Telah Terposting'
    created_at = datetime.datetime.now()
    result = cursor.execute("INSERT INTO log_job(id_account, status, kategori, created_at) VALUES (%s, %s, %s, %s)", (id_account, status, kategori, created_at))
    mysql.connection.commit()
    cursor.close()
    return ({"status":"success"})


@app.route('/input_image', methods = ['POST'])
def api_root():
    app.logger.info(PROJECT_HOME)
    if request.method == 'POST' and request.files['image']:
    	app.logger.info(app.config['UPLOAD_FOLDER'])
    	img = request.files['image']
    	img_name = secure_filename(img.filename)
    	#create_new_folder(app.config['UPLOAD_FOLDER'])
    	saved_path = os.path.join(app.config['UPLOAD_FOLDER'], img_name)
    	app.logger.info("saving {}".format(saved_path))
    	img.save(saved_path)
    	return send_from_directory(app.config['UPLOAD_FOLDER'],img_name, as_attachment=True)
    else:
    	return "Where is the image?"


@app.route('/posting_data', methods=['POST'])
def posting():
    if request.method == "POST":
        details = request.form
        caption = details['caption']
        kategori = details['kategori']
        status = details['status']
        tgl = datetime.datetime.now()


    	app.logger.info(app.config['UPLOAD_FOLDER'])
    	img = request.files['image']
    	img_name = secure_filename(img.filename)
    	#create_new_folder(app.config['UPLOAD_FOLDER'])
    	saved_path = os.path.join(app.config['UPLOAD_FOLDER'], img_name)
    	app.logger.info("saving {}".format(saved_path))
    	img.save(saved_path)
    	send_from_directory(app.config['UPLOAD_FOLDER'],img_name, as_attachment=True)


        cur = mysql.connection.cursor()
        cur.execute("INSERT INTO posting(caption, photo, kategori, status) VALUES (%s, %s, %s, %s)", (caption, img_name, kategori, status))
        mysql.connection.commit()
        cur.close()
        return ({"status":"success"})
    return ({"status":"success"})



if __name__ == '__main__':
     app.run(debug=True)
