----
-- phpLiteAdmin database dump (https://bitbucket.org/phpliteadmin/public)
-- phpLiteAdmin version: 1.9.6
-- Exported: 7:13pm on October 15, 2020 (UTC)
-- database file: /usr/share/nginx/databases/database.sqlite
----
BEGIN TRANSACTION;

----
-- Table structure for role
----
CREATE TABLE role (
	'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
	'name' TEXT NOT NULL
);

----
-- Data dump for role, a total of 2 rows
----
INSERT INTO "role" ("id","name") VALUES ('1','Collaborateur');
INSERT INTO "role" ("id","name") VALUES ('2','Administrateur');

----
-- Table structure for messages
----
CREATE TABLE 'messages' ('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'messageDate' TEXT NOT NULL DEFAULT CURRENT_DATE, 'sender' TEXT NOT NULL, 'receiver' TEXT NOT NULL, 'subject' TEXT NOT NULL, 'messageContent' TEXT NOT NULL);

----
-- Data dump for messages, a total of 3 rows
----
INSERT INTO "messages" ("id","messageDate","sender","receiver","subject","messageContent") VALUES ('24','2020-10-15','michael.dasilva','admin','test','petit test de la messagerie
michael');
INSERT INTO "messages" ("id","messageDate","sender","receiver","subject","messageContent") VALUES ('25','2020-10-15','admin','michael.dasilva','RE: test','OK parfait
------------------------------------------------------------
De : michael.dasilva
Envoyé le : 2020-10-15
Sujet : test
Message :

petit test de la messagerie
michael');
INSERT INTO "messages" ("id","messageDate","sender","receiver","subject","messageContent") VALUES ('26','2020-10-15','admin','STIproject','Welcome','Bienvenue dans votre nouvelle messagerie
admin');

----
-- Table structure for account
----
CREATE TABLE 'account' ('username' TEXT PRIMARY KEY NOT NULL, 'password' TEXT NOT NULL, 'validity' BOOLEAN NOT NULL DEFAULT 0 , 'role_id' INTEGER NOT NULL);

----
-- Data dump for account, a total of 3 rows
----
INSERT INTO "account" ("username","password","validity","role_id") VALUES ('admin','admin','1','2');
INSERT INTO "account" ("username","password","validity","role_id") VALUES ('STIproject','sti','1','1');
INSERT INTO "account" ("username","password","validity","role_id") VALUES ('test2','test','0','1');

----
-- structure for index sqlite_autoindex_account_1 on table account
----
;
COMMIT;
