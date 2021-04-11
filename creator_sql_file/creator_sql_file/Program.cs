using System;
using System.Collections.Generic;
using System.IO;

namespace creator_sql_file
{
    class Program
    {

        public static Random random = new Random();

        public static string GetVariant(int var)
        {
            if (var == 1)
            {
                if (random.Next(0, 2) == 0)
                {
                    return "NULL";
                }
                else
                {
                    return "\'" + random.Next(1, 57).ToString() + "\'";
                }
            }
            else
            {
                if (random.Next(0, 2) == 0)
                {
                    return "NULL";
                }
                else
                {
                    return "\'" + random.Next(1, 841).ToString() + "\'";
                }
            }
        }

        static void Main(string[] args)
        {

            using (FileStream fstream = new FileStream($"sql_insert_data.sql", FileMode.OpenOrCreate))
            {
                Dictionary<string, string> activities = new Dictionary<string, string>(14);

                activities.Add("Маркетинг", "marketing.svg");
                activities.Add("Web-разработка", "web-dev.svg");
                activities.Add("Web - дизайн", "web-des.svg");
                activities.Add("UI/UX дизайн", "uiux.svg");
                activities.Add("Frontend", "frontend.svg");
                activities.Add("Backend", "backend.svg");
                activities.Add("SEO", "seo.svg");
                activities.Add("SMM", "smm.svg");
                activities.Add("Реклама", "adversting.svg");
                activities.Add("Аналитика", "analytics.svg");
                activities.Add("Логистика", "logistic.svg");
                activities.Add("Менеджмент", "management.svg");
                activities.Add("Финансы", "finance.svg");
                activities.Add("Планирование", "planing.svg");

                string[] colorsActivities = {
                    "CE5555",
                    "59B5D2",
                    "3984CA",
                    "B46DED",
                    "EB9E57",
                    "5361E0",
                    "7CB94B",
                    "DD6E88",
                    "D77843",
                    "3B4C75",
                    "6A7D94",
                    "A85591",
                    "388640",
                    "48BDB6"
                };


                int idColor = 0;
                foreach (KeyValuePair<string, string> obj in activities)
                {
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `activity` (`id_act`, `name`, `logo`, `mark`) " +
                        "VALUES (NULL, " +
                        "\'" + obj.Key + "\', " +
                        "\'/pictures/icons/activities/" + obj.Value + "\', " +
                        "\'#"+ colorsActivities[idColor] + "\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                    idColor++;
                }

                string[] specialization = {
                    "Не выбрано",
                    "Web-разработчик",
                    "Web-дизайнер",
                    "Аналитик",
                    "HR",
                    "Финансовый директор",
                    "Программист JavaScript",
                    "HTML-верстальщик",
                    "Программист PHP",
                    "Программист Ruby",
                    "Программист Python",
                    "Программист Java",
                    "Программист C# (.NET)",
                    "Программист SQL/Oracle",
                    "Программист Swift (ObC)",
                    "Программист Android (java)",
                    "Программист Unity3d (С#)",
                    "Программист Unreal Engine (С++)",
                    "Программист 1С",
                    "Программист С++ / C",
                    "Сетевой инженер",
                    "Системный администратор",
                    "DevOps",
                    "Администратор 1С",
                    "SEO-специалист",
                    "Менеджер интернет-проектов",
                    "Руководитель отдела IT (поддержка)",
                    "Системный аналитик",
                    "Специалист по ИБ",
                    "Тестировщик",
                    "Контент-менеджер",
                    "3D-дизайнер",
                    "Копирайтер",
                    "Таргетолог",
                    "TeamLead",
                    "Embedded-программист",
                    "QA-инженер",
                    "Разработчик баз данных",
                    "iOS-разработчик",
                    "UI дизайнер",
                    "UX дизайнер"
                };

                string[] colors = {
                    "CC2E2E",
                    "DE7D24",
                    "F8C032",
                    "53AC34",
                    "5CA4E6",
                    "4153F5",
                    "853CA7"
                };

                string[] users_colors = {
                    "0777C8",
                    "BF3BBA",
                    "E9427E"
                };

                for (int i = 0; i < specialization.Length; i++) {
                    // преобразуем строку в байты
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `specialization` (`id_spec`, `name`) VALUES(NULL, \'" + specialization[i] + "\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                }

                for (int i = 0; i < specialization.Length; i+=3)
                {
                    for (int j = 0; j < 2; j++) 
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `user` (`id_user`, `id_spec`, `email`, `password`, `password_cookie_token`, `nickname`, `name`, `surname`, `avatar`) VALUES(NULL, " +
                            "\'"+(i+1).ToString()+"\', " +
                            "\'emailexample" + (j + 1).ToString() + (i + 1).ToString() + "@mail.ru\', " +
                            "\'password" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'\', " +
                            "\'nickname" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'name" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'surname" + (j + 1).ToString() + (i + 1).ToString() + "\', " + 
                            "\'/pictures/users_avatar/default-avatar.svg\');"
                            );                       
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }

                for(int i = 1; i <= 28; i++)
                {
                    for (int j = 0; j < 2; j++)
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `project` (`id_project`, `id_user`, `creator`, `name`, `descr`, `mark`) VALUES(NULL, " +
                            "\'" + i.ToString() + "\', " +
                            "\'"+random.Next(0,2)+"\', " +
                            "\'Project№" + (j + 1).ToString() + i.ToString() + "\', " + 
                            "\'Project description...\', " +
                            "'#323232');"
                            );                                                                                 
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }

                int month;
                int day;

                for (int i = 1; i <= 56; i++)
                {
                    month = random.Next(1, 13);

                    for (int j = 0; j < 3; j++)
                    {

                        if (month == 2)
                        {
                            day = random.Next(1, 29);
                        }
                        else
                        {
                            if (month >= 8)
                            {
                                if (month % 2 == 0)
                                {
                                    day = random.Next(1, 32);
                                }
                                else
                                {
                                    day = random.Next(1, 31);
                                }
                            }
                            else
                            {
                                if (month % 2 == 0)
                                {
                                    day = random.Next(1, 31);
                                }
                                else
                                {
                                    day = random.Next(1, 32);
                                }
                            }
                        }

                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `attachment` (`id_attach`, `id_project`, `id_user`, `comment`, `date`, `time`) VALUES(NULL, " +
                            "\'" + random.Next(1, 57) + "\', " +
                            "\'" + random.Next(1, 29) + "\', " +
                            "\'TextComments - " + random.Next(0, 90000) + "\', " +
                            "\'2021-" + month.ToString() + "-" + day.ToString() + "\', " +
                            "\'" + random.Next(0, 25) + ":" + random.Next(0, 60) + ":00\');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }
                
                
                for (int i = 1; i <= 56; i++)
                {
                    for (int j = 1; j <= 3; j++) 
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `target` (`id_target`, `id_project`, `name`, `descr`, `mark`) VALUES(NULL, " +
                            "\'" + i.ToString() + "\', " +
                            "\'Target№" + random.Next(0, 100) + "\', " + 
                            "\'Target description...\', " +
                            "'#121212');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }


                for (int m = 1; m <= 5; m++)
                {
                    for (int t = 1; t <= 168; t++)
                    {
                        for (int c = 1; c <= 5; c++)
                        {
                            if (m == 2)
                            {
                                day = random.Next(1, 29);
                            }
                            else
                            {
                                if (m >= 8)
                                {
                                    if (m % 2 == 0)
                                    {
                                        day = random.Next(1, 32);
                                    }
                                    else
                                    {
                                        day = random.Next(1, 31);
                                    }
                                }
                                else
                                {
                                    if (m % 2 == 0)
                                    {
                                        day = random.Next(1, 31);
                                    }
                                    else
                                    {
                                        day = random.Next(1, 32);
                                    }
                                }
                            }

                            // преобразуем строку в байты
                            byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                                "INSERT INTO `task` (`id_task`, `id_target`, `executor`, `text`, `descr`, `date`, `duration`, `status`) VALUES(NULL, " +
                                "\'" + t.ToString() + "\', " +
                                "\'" + random.Next(1, 29) + "\', " +
                                "\'Task - " + random.Next(1, 90000) + "\', " +
                                "\'Description - " + random.Next(1, 90000) + "\', " +
                                "\'2021-0" + m.ToString() + "-" + day.ToString() + "\', " +
                                "\'" + random.Next(1, 481) + "\', " +
                                "\'" + random.Next(0, 2) + "\');"
                                );
                            // запись массива байтов в файл
                            fstream.Write(array, 0, array.Length);
                        }
                    }
                }

                for (int i = 1; i <= 50; i++)
                {
                    for (int j = 1; j <= 2; j++)
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `subtask` (`id_subtask`, `id_task`, `text`, `status`) VALUES(NULL, " +
                            "\'" + random.Next(1, 841) + "\', " +
                            "\'TextSubtask - " + random.Next(1, 90000) + "\', " +
                            "\'" + random.Next(0, 2) + "\');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }


                for (int i = 1; i <= 75; i++)
                {
                    for (int j = 1; j <= 2; j++)
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `team` (`id_team`, `id_target`, `id_act`) VALUES(NULL, " +
                            "\'" + random.Next(1, 169) + "\', " +
                            "\'" + random.Next(1, 15) + "\');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }

                for (int i = 1; i <= 75; i++)
                {
                    for (int j = 1; j <= 2; j++)
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `file` (`id_file`, `id_attach`, `id_task`, `name`, `path`) VALUES(NULL, " +
                            "" + GetVariant(1) + ", " +
                            "" + GetVariant(2) + ", " +
                            "\'FileName - " + random.Next(1, 90000) + "\', " +
                            "\'uploads/file" + random.Next(1, 90000) + ".png\');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }


                for (int i = 1; i <= 100; i++)
                {           
                    // преобразуем строку в байты
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `user_team` (`id_user`, `id_team`) VALUES(" +
                        "\'" + random.Next(1, 29) + "\', " +
                        "\'" + random.Next(1, 151) + "\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                }

                for (int i = 0; i < users_colors.Length; i++)
                {
                    for (int j = 1; j <= 28; j++) 
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `colors` (`id_color`, `id_user`, `value`) VALUES(NULL, " + j + ", \'#" + users_colors[random.Next(0,3)] + "\');");
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }

                Console.WriteLine("Файл создан!");
            }

            Console.ReadKey();
        }  
    }
}
