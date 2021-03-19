drop function if exists getCurrentPerformance;
drop function if exists getProjectPercentComplete;
drop function if exists getCountTargetProjects;
drop function if exists getCountTaskProjects;
drop function if exists getTargetPercentComplete;
drop function if exists getCountSubtask;
drop function if exists getDoneSubtask;
drop function if exists getExecutorTask;
drop function if exists getExecutorsProject;
drop function if exists getSpecExecutor;

DELIMITER //

CREATE FUNCTION getCurrentPerformance(idUser INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_tasks INT;
	DECLARE done_tasks INT;
 
  	SELECT COUNT(id_task) INTO count_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	INNER JOIN project ON project.id_project = target.id_project 
  	INNER JOIN user ON user.id_user = project.id_user 
  	WHERE user.id_user = idUser;
    
    SELECT COUNT(id_task) INTO done_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	INNER JOIN project ON project.id_project = target.id_project 
  	INNER JOIN user ON user.id_user = project.id_user 
  	WHERE user.id_user = idUser AND task.status = 1;
    
    IF count_tasks = 0 THEN
    	RETURN 0;
    ELSE
  		RETURN (done_tasks*100)/count_tasks;
    END IF;
END //


CREATE FUNCTION getCountTaskProjects(idProject INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_tasks INT;
 
  	SELECT COUNT(id_task) INTO count_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	INNER JOIN project ON project.id_project = target.id_project 
  	WHERE project.id_project = idProject;
    
   	RETURN count_tasks;
END //


CREATE FUNCTION getProjectPercentComplete(idProject INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_tasks INT;
	DECLARE done_tasks INT;
 
  	SELECT getCountTaskProjects(idProject) INTO count_tasks;
    
    SELECT COUNT(id_task) INTO done_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	INNER JOIN project ON project.id_project = target.id_project
  	WHERE project.id_project = idProject AND task.status = 1;
    
    IF count_tasks = 0 THEN
    	RETURN 0;
    ELSE
  		RETURN (done_tasks*100)/count_tasks;
    END IF;
END //

CREATE FUNCTION getTargetPercentComplete(idTarget INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_tasks INT;
	DECLARE done_tasks INT;
 
  	SELECT COUNT(id_task) INTO count_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	WHERE target.id_target = idTarget;
    
    SELECT COUNT(id_task) INTO done_tasks FROM task
  	INNER JOIN target ON target.id_target = task.id_target 
  	WHERE target.id_target = idTarget AND task.status = 1;
    
    IF count_tasks = 0 THEN
    	RETURN 0;
    ELSE
  		RETURN (done_tasks*100)/count_tasks;
    END IF;
END //

CREATE FUNCTION getCountTargetProjects(idProject INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_target INT;
 
  	SELECT COUNT(id_target) INTO count_target FROM target 
  	INNER JOIN project ON project.id_project = target.id_project 
  	WHERE project.id_project = idProject;
    
   	RETURN count_target;
END //

CREATE FUNCTION getCountSubtask(idTask INT) RETURNS int DETERMINISTIC
BEGIN
	DECLARE count_subtasks INT;
 
  	SELECT COUNT(id_subtask) INTO count_subtasks FROM subtask 
  	INNER JOIN task ON task.id_task = subtask.id_task
  	WHERE task.id_task = idTask;
    
   	RETURN count_subtasks;
END //

CREATE FUNCTION getDoneSubtask(idTask INT) RETURNS int DETERMINISTIC
BEGIN
 	DECLARE done_subtasks INT;
    
    SELECT COUNT(id_subtask) INTO done_subtasks FROM subtask 
  	INNER JOIN task ON task.id_task = subtask.id_task
  	WHERE task.id_task = idTask AND subtask.status = 1;
    
   	RETURN done_subtasks;
END //

CREATE FUNCTION getExecutorsProject(idProject INT) RETURNS VARCHAR(100) DETERMINISTIC
BEGIN
	DECLARE name VARCHAR(50);
	DECLARE surname VARCHAR(50);
    DECLARE user_id INT;
	DECLARE specialization VARCHAR(100);

	SELECT user.id_user, user.name, user.surname, specialization.name INTO user_id, name, surname, specialization FROM user 
	INNER JOIN user_team ON user_team.id_user = user.id_user 
	INNER JOIN team ON team.id_team = user_team.id_team
	INNER JOIN specialization ON specialization.id_spec = user.id_spec
	WHERE team.id_team IN 
        (SELECT team.id_team FROM team 
        INNER JOIN target ON target.id_target = team.id_target 
        INNER JOIN project ON project.id_project = target.id_project
        WHERE project.id_project = idProject);

	/*SELECT specialization.name INTO specialization FROM specialization 
	INNER JOIN user ON user.id_spec = specialization.id_spec
	WHERE user.id_user = user_id;	*/

	RETURN CONCAT_WS('|', user_id, name, surname, specialization);
    /*RETURN specialization;*/
END //


DELIMITER ;