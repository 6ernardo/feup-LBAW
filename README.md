# UP Connect

The *UP Connect* web application is being developed by a small team of Computer Engineering students as a product targeted at fellow university students that want a way to learn and share knowledge related to their academic lifestyle in University of Porto.

The main goal of the project is the development of a web-based application that focuses on giving the students from University of Porto a way to share questions, knowledge and resources in an efficient and organized manner. The application allows users to authenticate and gain certain privileges in the site. A team of administrators is defined, which will be responsible for managing the system and users, ensuring it runs smoothly.


### 1. Installation

The Docker command to test the image of the project is the following:

```
docker run -it -p 8000:80 --name=lbaw2381 -e DB_DATABASE="lbaw2381" -e DB_SCHEMA="lbaw2381" -e DB_USERNAME="lbaw2381" -e DB_PASSWORD="SmQVIFBY" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw2381
```

### 2. Usage

The application is available at https://lbaw2381.lbaw.fe.up.pt.


#### 2.1. Administration Credentials

| Username | Email |Password |
| -------- |-------- |-------- |
| admin    | admin@admin.com|1234567890 |

#### 2.2. User Credentials

| Type          | Username  | Email | Password |
| ------------- | --------- | -------- | -------- |
| Moderator | mod    | mod@mod.com |qwertyuiop |
| User   | client    | client@client.com |12345yuiop |
