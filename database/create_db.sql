ALTER TABLE "user" DROP FOREIGN KEY "user_id_spec_specialization_id_spec_foreign";
ALTER TABLE "project" DROP FOREIGN KEY "project_id_user_user_id_user_foreign";
ALTER TABLE "attachment" DROP FOREIGN KEY "note_id_project_project_id_project_foreign";
ALTER TABLE "target" DROP FOREIGN KEY "target_id_project_project_id_project_foreign";
ALTER TABLE "task" DROP FOREIGN KEY "task_id_target_target_id_target_foreign";
ALTER TABLE "team" DROP FOREIGN KEY "team_id_act_activity_id_act_foreign";
ALTER TABLE "team" DROP FOREIGN KEY "team_id_target_target_id_target_foreign";
ALTER TABLE "team" DROP FOREIGN KEY "team_id_user_user_id_user_foreign";
ALTER TABLE "file" DROP FOREIGN KEY "file_id_note_note_id_note_foreign";
ALTER TABLE "file" DROP FOREIGN KEY "file_id_task_task_id_task_foreign";
ALTER TABLE "subtask" DROP FOREIGN KEY "subtask_id_task_task_id_task_foreign";
DROP TABLE IF EXISTS "activity";
DROP TABLE IF EXISTS "specialization";
DROP TABLE IF EXISTS "user";
DROP TABLE IF EXISTS "project";
DROP TABLE IF EXISTS "attachment";
DROP TABLE IF EXISTS "target";
DROP TABLE IF EXISTS "task";
DROP TABLE IF EXISTS "team";
DROP TABLE IF EXISTS "file";
DROP TABLE IF EXISTS "subtask";

CREATE TABLE IF NOT EXISTS "activity" (
  "id_act" int(10) AUTO_INCREMENT NOT NULL,
  "name" varchar(100) DEFAULT NULL,
  PRIMARY KEY ("id_act")
);

CREATE TABLE IF NOT EXISTS "specialization" (
  "id_spec" int(10) AUTO_INCREMENT NOT NULL,
  "name" varchar(100) NOT NULL,
  PRIMARY KEY ("id_spec")
);

CREATE TABLE IF NOT EXISTS "user" (
  "id_user" int(10) AUTO_INCREMENT NOT NULL,
  "id_spec" int(10) NOT NULL,
  "email" varchar(255) DEFAULT NULL,
  "password" varchar(50) DEFAULT NULL,
  "login" varchar(255) NOT NULL,
  "name" varchar(100) NOT NULL,
  "surname" varchar(255) NOT NULL,
  "avatar" text DEFAULT NULL,
  PRIMARY KEY ("id_user"),
  CONSTRAINT "user_id_spec_specialization_id_spec_foreign" FOREIGN KEY ("id_spec") REFERENCES "specialization" ("id_spec") ON UPDATE CASCADE ON DELETE
  SET
    NULL
);

CREATE TABLE IF NOT EXISTS "project" (
  "id_project" int(10) AUTO_INCREMENT NOT NULL,
  "id_user" int(10) NOT NULL,
  "creator" tinyint(1) NOT NULL,
  "name" varchar(100) NOT NULL,
  "mark" varchar(50) NOT NULL,
  PRIMARY KEY ("id_project"),
  CONSTRAINT "project_id_user_user_id_user_foreign" FOREIGN KEY ("id_user") REFERENCES "user" ("id_user") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "attachment" (
  "id_note" int(10) AUTO_INCREMENT NOT NULL,
  "id_project" int(10) NOT NULL,
  "comment" text NOT NULL,
  "date" date NOT NULL,
  "time" time NOT NULL,
  PRIMARY KEY ("id_note"),
  CONSTRAINT "note_id_project_project_id_project_foreign" FOREIGN KEY ("id_project") REFERENCES "project" ("id_project") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "target" (
  "id_target" int(10) AUTO_INCREMENT NOT NULL,
  "id_project" int(10) NOT NULL,
  "name" varchar(255) NOT NULL,
  "mark" varchar(255) NOT NULL,
  PRIMARY KEY ("id_target"),
  CONSTRAINT "target_id_project_project_id_project_foreign" FOREIGN KEY ("id_project") REFERENCES "project" ("id_project")
);

CREATE TABLE IF NOT EXISTS "task" (
  "id_task" int(10) AUTO_INCREMENT NOT NULL,
  "id_target" int(10) NOT NULL,
  "text" varchar(255) NOT NULL,
  "descr" varchar(255) DEFAULT NULL,
  "duration" int(10) NOT NULL,
  "status" tinyint(1) DEFAULT 0 NOT NULL,
  "failed" tinyint(1) NOT NULL,
  PRIMARY KEY ("id_task"),
  CONSTRAINT "task_id_target_target_id_target_foreign" FOREIGN KEY ("id_target") REFERENCES "target" ("id_target") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "team" (
  "id_team" int(10) NOT NULL,
  "id_target" int(10) NOT NULL,
  "id_user" int(10) NOT NULL,
  "id_act" int(10) NOT NULL,
  "name" varchar(100) NOT NULL,
  "mark" varchar(50) NOT NULL,
  PRIMARY KEY ("id_team"),
  CONSTRAINT "team_id_act_activity_id_act_foreign" FOREIGN KEY ("id_act") REFERENCES "activity" ("id_act") ON UPDATE CASCADE ON DELETE
  SET
    NULL,
    CONSTRAINT "team_id_target_target_id_target_foreign" FOREIGN KEY ("id_target") REFERENCES "target" ("id_target") ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT "team_id_user_user_id_user_foreign" FOREIGN KEY ("id_user") REFERENCES "user" ("id_user") ON UPDATE CASCADE ON DELETE
  SET
    NULL
);

CREATE TABLE IF NOT EXISTS "file" (
  "id_file" int(10) AUTO_INCREMENT NOT NULL,
  "id_attach" int(10) NOT NULL,
  "id_task" int(10) NOT NULL,
  "name" varchar(255) NOT NULL,
  "path" varchar(255) NOT NULL,
  PRIMARY KEY ("id_file"),
  CONSTRAINT "file_id_note_note_id_note_foreign" FOREIGN KEY ("id_attach") REFERENCES "attachment" ("id_note") ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT "file_id_task_task_id_task_foreign" FOREIGN KEY ("id_task") REFERENCES "task" ("id_task") ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS "subtask" (
  "id_subtask" int(10) AUTO_INCREMENT NOT NULL,
  "id_task" int(10) NOT NULL,
  "text" varchar(255) NOT NULL,
  "status" tinyint(1) DEFAULT 0 NOT NULL,
  PRIMARY KEY ("id_subtask"),
  CONSTRAINT "subtask_id_task_task_id_task_foreign" FOREIGN KEY ("id_task") REFERENCES "task" ("id_task") ON UPDATE CASCADE ON DELETE CASCADE
);