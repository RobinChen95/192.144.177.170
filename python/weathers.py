# coding: utf-8

import sys
import requests
import pymysql
from bs4 import BeautifulSoup as bs

reload(sys)
sys.setdefaultencoding('utf-8')

conn = pymysql.connect(
    host = 'localhost',
    port = 3306,
    user = 'www_messj_xyz',
    passwd = 'dARbmPsQWJ',
    db = 'www_messj_xyz',
    charset = 'utf8'
)

cursor = conn.cursor(cursor = pymysql.cursors.DictCursor)
cursor.execute('select weather_code from ins_county')
result = cursor.fetchall()

conn.commit()



for i in range(len(result)):
    citycode = result[i]['weather_code']
    url = "http://wthrcdn.etouch.cn/WeatherApi?citykey=" + citycode
    r = requests.get(url, verify = False)
    soup = bs(r.text, 'html.parser')

    wendu = soup.find('wendu').text
    fengli = soup.find('fengli').text
    shidu = soup.find('shidu').text
    fengxiang = soup.find('fengxiang').text
    wendu = soup.find('wendu').text
    if soup.find('pm25'):
        pm25 = soup.find('pm25').text
    else:
        pm25 = 'Null'
    if soup.find('quality'):
        quality = soup.find('quality').text
    else:
        quality = 'Null'    
    if soup.find('high_1'):
        high = soup.find('high').text
    else:
        high = 'Null'
    if soup.find('low_1'):
        low = soup.find('low').text
    else:
        low = 'Null'
    weather_content = '温度：' + wendu + "\n" + \
                      '风力：' + fengli + "\n" + \
                      '湿度：' + shidu + "\n" + \
                      '风向：' + fengxiang + "\n" + \
                      'PM2.5：' + pm25 + "\n" + \
                      '空气质量：' + quality + "\n" + \
                      low + '-' + high + "\n"

    sql_exe = 'UPDATE ins_county SET weather_info = \''\
              + weather_content + '\' WHERE weather_code = ' +citycode+' '

    cursor.execute(sql_exe)
    conn.commit()
 
cursor.close()
conn.close()