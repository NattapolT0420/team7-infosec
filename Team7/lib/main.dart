import 'dart:async';
import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'TEAM7 Infosec',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: MyHomePage(),
    );
  }
}

class MyHomePage extends StatefulWidget {
  @override
  _MyHomePageState createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  final formkey = GlobalKey<FormState>();

  TextEditingController username = new TextEditingController();
  TextEditingController password = new TextEditingController();

  Future login() async {
    final response = await http.post(
        Uri.parse("http://nattapolt.ddns.net:100/Team7-PHP/login.php"),
        body: {
          "username": username.text,
          "password": password.text,
        });

    var data = jsonDecode(response.body);

    if (data.length == 0) {
      myAlert("Username or Password is incorrect");
    } else if (data.length == 1) {
      myAlert(
          "Login Success \n \n " + data[0]['name'] + " " + data[0]['surname']);
    } else {
      myAlert("Login Fail");
    }
    // print(data[0]['username']);
    // return data;
  }

  void myAlert(String msg) {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            content: Text(
              msg,
              textAlign: TextAlign.center,
            ),
            actions: [
              FlatButton(
                onPressed: () {
                  Navigator.of(context).pop();
                },
                child: Text('OK'),
              ),
            ],
          );
        });
  }

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return Scaffold(
      appBar: AppBar(
        title: Text(
          'LOGIN',
          style: TextStyle(
            fontSize: 35,
            fontWeight: FontWeight.w600,
            color: Colors.white,
          ),
        ),
        centerTitle: true,
        backgroundColor: Color(0xFF03A9F4),
      ),
      body: Form(
        key: formkey,
        child: Center(
          child: Container(
            decoration: BoxDecoration(
              image: DecorationImage(
                image: AssetImage("asset/Image/bg.png"),
                fit: BoxFit.cover,
              ),
            ),
            child: Container(
              margin: EdgeInsets.all(20),
              child: Center(
                child: ListView(
                  children: [
                    SizedBox(
                      height: size.height * 0.01,
                    ),
                    Image.asset(
                      'asset/Image/login.png',
                      width: 100,
                      height: 200,
                    ),
                    SizedBox(
                      height: size.height * 0.03,
                    ),
                    TextFormField(
                      controller: username,
                      decoration: InputDecoration(
                        icon: Icon(
                          Icons.person,
                          color: Color(0xFFff5722),
                        ),
                        labelText: 'Username',
                        labelStyle: TextStyle(
                          fontSize: 20,
                          color: Color(0xFFff5722),
                          fontWeight: FontWeight.bold,
                        ),
                        helperText: 'Input username',
                        helperStyle: TextStyle(
                          fontSize: 16,
                          color: Colors.blue[900],
                        ),
                      ),
                      style: TextStyle(
                        fontSize: 16,
                      ),
                      validator: (value) {
                        if (value!.isEmpty) {
                          return 'Please fill this out';
                        } else {
                          return null;
                        }
                      },
                      onSaved: (value) => username,
                    ),
                    TextFormField(
                      controller: password,
                      decoration: InputDecoration(
                        icon: Icon(
                          Icons.lock,
                          color: Colors.green[700],
                        ),
                        labelText: 'Password',
                        labelStyle: TextStyle(
                          fontSize: 20,
                          color: Colors.green[700],
                          fontWeight: FontWeight.bold,
                        ),
                        helperText: 'Input password',
                        helperStyle: TextStyle(
                          fontSize: 16,
                          color: Colors.blue[900],
                        ),
                      ),
                      obscureText: true,
                      validator: (value) {
                        if (value!.length < 13) {
                          return 'Password More 13 Charator';
                        } else {
                          return null;
                        }
                      },
                      onSaved: (value) => password,
                    ),
                    SizedBox(
                      height: size.height * 0.1,
                    ),
                    RaisedButton(
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(20.0),
                        side: BorderSide(color: Color(0xFFff5722)),
                      ),
                      //padding: EdgeInsets.all(12),
                      onPressed: () {
                        // print('Login');
                        if (formkey.currentState!.validate()) {
                          formkey.currentState!.save();
                          print('Username: ' +
                              username.text +
                              ' Password: ' +
                              password.text);
                          login();
                          // String result = login().toString();
                          // ScaffoldMessenger.of(context).showSnackBar(
                          //   const SnackBar(content: Text()),
                          // );
                          // print(msg);
                        }
                      },
                      child: Text(
                        'LOGIN'.toUpperCase(),
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 18,
                        ),
                      ),
                      color: Color(0xFFff5722),
                    ),
                    RaisedButton(
                      onPressed: () => print('Register'),
                      child: Text(
                        'Register for new account',
                        style: TextStyle(
                          color: Color(0xFF3f3d56),
                          fontSize: 16,
                        ),
                      ),
                      color: Color.fromRGBO(255, 255, 255, 0),
                      elevation: 0,
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}
