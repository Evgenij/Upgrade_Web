drop function if exists getCurrentPerformance;
drop function if exists getProjectPercentComplete;
drop function if exists getCountTargetProjects;
drop function if exists getCountTaskProjects;
drop function if exists getTargetPercentComplete;
drop function if exists getCountSubtask;
drop function if exists getDoneSubtask;
drop function if exists getCountAttachProject;
drop function if exists getCountParticProject;

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


CREATE FUNCTION getCountAttachProject(idProject INT) RETURNS int DETERMINISTIC
BEGIN
 	DECLARE count_attach INT;
    
    SELECT COUNT(id_attach) INTO count_attach FROM attachment 
  	WHERE attachment.id_project = idProject;
    
   	RETURN count_attach;
END //


CREATE FUNCTION getCountParticProject(idProject INT) RETURNS int DETERMINISTIC
BEGIN
 	DECLARE count INT;
    
    SELECT DISTINCT COUNT(*) INTO count FROM target 
	INNER JOIN team ON team.id_target = target.id_target 
	INNER JOIN user_team ON user_team.id_team = team.id_team 
	INNER JOIN user ON user.id_user = user_team.id_user 
	WHERE target.id_target IN 
		(SELECT target.id_target FROM target 
		WHERE target.id_project = idProject) 
	ORDER BY team.id_team;

	RETURN count;
END //


DELIMITER ;