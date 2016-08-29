# Stored Procs for Learning X by Patrick Hill

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `addAnswers`(in question_id INT, in choice varchar(50), in correct tinyint(1))
BEGIN
insert into answers (questionID,answer,correct) values(question_id,choice,correct);
SELECT LAST_INSERT_ID()as lastinsert, 'Success' as created;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `addQuestion`(in topic_id INT, in question text, in ac1 varchar(100),
in ac2 varchar(100),in ac3 varchar(100),in ac4 varchar(100),
in ac5 varchar(100),in ac6 varchar(100), in correct varchar(4))
BEGIN
insert into questions (questionTopicID, question) values (topic_id, question);
SELECT LAST_INSERT_ID()  into @questionid;

if (ac1  is null or ac1='') then
	select 1;
else
	if (correct='ac1') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac1,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac1,0);
	end if;
end if;

if (ac2 is  null or ac2='') then
	select 1;
else
	if (correct='ac2') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac2,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac2,0);
	end if;
	
end if;

if (ac3 is  null or ac3='') then
	select 1;
else
	if (correct='ac3') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac3,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac3,0);
	end if;
end if;
if (ac4 is null or ac4='') then
	select 1;
else
	if (correct='ac4') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac4,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac4,0);
	end if;
end if;

if (ac5 is  null or ac5='') then
	select 1;
else
	if (correct='ac5') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac5,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac5,0);
	end if;
end if;

if (ac6 is  null or ac6='') then
	select 1;
else
if (correct='ac6') then
		insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac6,1);
	else
	insert into answers(questionID,answer,correct) values ((SELECT @questionid),ac6,0);
	end if;
end if;




END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `addTopic`(IN topic_name VarChar(50))
BEGIN
Insert into topics (topic) values(topic_name);
SELECT LAST_INSERT_ID()as lastinsert, 'Success' as created;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `changePassword`(in oldpass text, in newPass TEXT,in userName varchar(45))
BEGIN
SELECT salt ,password,id into @salt, @storedpw,@userID from users where users.username=userName;
SELECT SHA2(CONCAT(oldpass, (select @salt)),256) =(select @storedpw) into @oldmatch;



if (select @oldmatch=1) then
SELECT FLOOR(RAND() * 0xFFFFFFFF) into @newSalt;
update users set salt=(select @newSalt),users.password=sha2(concat(newPass,(select @newSalt)),256) where users.username=userName;
select 'success' as updated;

else
select 'failed' as updated;
end if;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `checkPassword`(IN usr_name VARCHAR(50), IN usr_password TEXT)
BEGIN
if  (SELECT checkUsername(usr_name))=1 then
	SELECT salt ,password,id into @salt, @storedpw,@userID from users where users.username=usr_name;
	SELECT (Select @userID) as uid,
	(SELECT SHA2(CONCAT(usr_password, (select @salt)),256) =(select @storedpw)) as loggedin, 
	(select first_name from users where users.username=usr_name) as firstname,
    (select instructor from users where users.username=usr_name) as instructor,
	(select users.username from users where id=(Select @userID)) as uName ;
	update users set last_login=now() where id=(Select @userID);
else
	select 0 as uid,'NOT IN SYSTEM' as loggedin,'' as firstname, '' as uName;
end if;
END$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `checkUsername`(IN userName varchar(45))
BEGIN
SELECT checkUsername(userName) as userFound;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `createResource`(in topic_id INT,in resource_type varchar(50),in resource_data text, in resource_display varchar(60), in featured_flag tinyint(1))
BEGIN
if (resource_type='Video' and featured_flag=1 and (select count(*) from resources where featured =1 and topicID=topic_id=1)) then
	update resources set featured=0 where featured=1 and topicID=topic_id;   
    SELECT 'Success' as created;
elseif(resource_type='Text' and (select count(*) from resources where topicID=topic_id and resourceType='Text' = 1)) then
	update resources set resource=resource_data where topicID=topic_id and resourceType='Text';
    SELECT 'Success' as created;
else
insert into resources (topicID,resourceType,resource,resourceDisplayName,featured) values (topic_id,resource_type,resource_data,resource_display,featured_flag);
SELECT LAST_INSERT_ID()as lastinsert, 'Success' as created;
end if;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `createUser`(
IN userName VARCHAR(50),
IN firstName VARCHAR(25),
IN lastName VARCHAR(25),
IN pass text)
BEGIN
SELECT FLOOR(RAND() * 0xFFFFFFFF) into @salt;
INSERT INTO `users` (`username`, `first_name`, `last_name`,`salt`,`password`) VALUES (userName, firstName,lastName, (select @salt),sha2(concat(pass,(select @salt)),256));
SELECT LAST_INSERT_ID()as lastinsert, 'Success' as created;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `forgotPassword`(IN userName varchar(45))
BEGIN
SELECT  users.password into @oldpw from users  where users.username=userName;
Update users set users.password=sha2(concat((select @oldpw),(SELECT FLOOR(RAND() * 0xFFFFFFFF))),256) where users.userName=userName;
select 1 as pwset, users.password as token from users where users.userName=userName;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getAnswers`(IN question_id INT)
BEGIN
SELECT *
FROM answers 
where questionID=question_id
order by RAND();
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getNonInstructorUsers`()
BEGIN
SELECT * FROM learningx.users WHERE instructor = 0;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getPractice`(IN topic_id INT)
BEGIN
SELECT *
FROM questions 
where questionTopicId=topic_id
ORDER BY RAND()
LIMIT 10;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getQuestionCount`(IN topic_level INT)
BEGIN
select count(*) as count from questions where questionTopicID=topic_level;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getQuestions`(IN quesLevel INT, IN numOfQues INT)
BEGIN
CASE
WHEN quesLevel IS NULL THEN
	SELECT question from questions
    ORDER BY RAND()
	LIMIT numOfQues;
ELSE
	SELECT question from questions
    WHERE quesionLevel = quesLevel
	ORDER BY RAND()
	LIMIT numOfQues;
END CASE;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getResources`(IN topic_id INT)
BEGIN
Select * from resources where topicID=topic_id;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getTextResource`(in topicid int)
BEGIN
select resource from resources where topicID=topidid and resourceType="Text";
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getTopics`()
BEGIN
Select topicID,topic from topics;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getUsername`(in pass TEXT)
BEGIN
Select users.username from users where users.password=pass;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getUsernameFromToken`(in pass TEXT)
BEGIN
Select users.username from users where users.password=pass;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `getUserProgress`(IN topic_level INT, IN user_id INT)
BEGIN
CASE
WHEN topic_level IS NULL THEN
Select level,(select count(*) from questions )as totalquestions, totalanswered, totalcorrect, ROUND((totalcorrect/totalanswered) * 100) as percentageCorrect from user_progress where userid=user_id;
ELSE
Select level,(select count(*) from questions where questionTopicID=topic_level )as totalquestions, totalanswered, totalcorrect, ROUND((totalcorrect/totalanswered) * 100) as percentageCorrect from user_progress where userid=user_id and level=topic_level;
END CASE;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `markQuestionAnswered`(in question_id INT,in user_id int, in answered_already int, in answered_correct int)
BEGIN
if (select count(*) from questionsanswered where questionid=question_id =1) then
	update questionsanswered
    set answeredAlready=answered_already, answeredCorrect=answered_correct
    where questionid=question_id and userid=user_id;
else
	insert into questionsanswered (questionid,userid,answeredAlready,answeredCorrect)
    values(question_id,user_id,answered_already,answered_correct);
    
end if;
SELECT 1;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `resetPassword`(in token text, in newPass TEXT,in userName varchar(45))
BEGIN
SELECT FLOOR(RAND() * 0xFFFFFFFF) into @salt;
update users set salt=(select @salt),users.password=sha2(concat(newPass,(select @salt)),256) where users.username=userName and users.password=token;
select 'success' as updated;

END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` PROCEDURE `updateProgress`(IN inLevel INT, IN user_id INT, IN correct INT)
BEGIN
if (select count(*) from user_progress where level=inLevel and userid=user_id =1) then
UPDATE user_progress
set totalcorrect=totalcorrect + correct, totalanswered=totalanswered+1, totalquestions=(Select count(*) from questions where questionLevel=level)
where level= inLevel and userid=user_id;
else 
insert into user_progress(level,userid,totalquestions,totalanswered,totalcorrect) 
values(inLevel,user_id,(Select count(*) from questions where questionLevel=inLevel),1,correct);
end if;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`learningx`@`%` FUNCTION `checkUsername`(userName varchar(45)) RETURNS int(11)
BEGIN
if (SELECT count(*) as userFound from users where users.username = userName)=1 then
	RETURN 1;
ELSE
	RETURN 0;
END IF;    
END$$
DELIMITER ;
