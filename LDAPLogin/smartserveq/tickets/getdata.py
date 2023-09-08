import requests
import json

url = "https://mmfss.freshservice.com/api/v2/requesters/27002431599"

payload = {}
headers = {
  'Authorization': 'Basic QVRtQ1hMR1FySWVvSk5TM1k1ZDI6IA=='
}

response = requests.request("GET", url, headers=headers, data=payload)
#print(response.status_code)

data = response.text
parse_json = json.loads(data)

#print (parse_json)
#info = parse_json['requesters']['reporting_manager_id'][0]
#print("Info about API:\n", info)

fname =         parse_json['requester']['first_name']
lname =         parse_json['requester']['last_name']
user_id =       parse_json['requester']['custom_fields']['user_id']
branch =        parse_json['requester']['custom_fields']['branch_name']
state =         parse_json['requester']['custom_fields']['state']
region =        parse_json['requester']['custom_fields']['region']
circle =        parse_json['requester']['custom_fields']['circle']
company =       parse_json['requester']['custom_fields']['company']
vertical =      parse_json['requester']['custom_fields']['vertical']
designation =   parse_json['requester']['job_title']
grade =         parse_json['requester']['custom_fields']['grade']
oprn =          parse_json['requester']['custom_fields']['operation_category']
mobile =        parse_json['requester']['mobile_phone_number']
primary_email = parse_json['requester']['primary_email']
rm_id =         parse_json['requester']['reporting_manager_id']

print ('Name is: ',fname, lname)
print ('Entity Code: ',user_id)
print ('Branch Name: ',branch)
print ('State: ',state)
print ('Region: ',region)
print ('Circle: ',circle)
print ('Company: ',company)
print ('Vertical: ',vertical)
print ('Designation: ', designation)
print ('Grade: ',grade)
print ('OPRN: ',oprn)
print ('Mobile No: ',mobile)
print ('Email ID: ',primary_email)
print ('RM Name: ',rm_id)