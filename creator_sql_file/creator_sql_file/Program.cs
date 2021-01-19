using System;
using System.Collections.Generic;
using System.IO;

namespace creator_sql_file
{
    class Program
    {
        

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

                foreach (KeyValuePair<string, string> obj in activities)
                {
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `activity` (`id_act`, `name`, `logo`) VALUES(NULL, \'" + obj.Key + "\', \'icons/activities/" + obj.Value + "\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                }

                string[] specialization = {
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

                for (int i = 0; i < specialization.Length; i++) {
                    // преобразуем строку в байты
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `specialization` (`id_spec`, `name`) VALUES(NULL, \'" + specialization[i] + "\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                }

                for (int i = 0; i < specialization.Length; i++)
                {
                    for (int j = 0; j < 2; j++) 
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `user` (`id_user`, `id_spec`, `email`, `password`, `nickname`, `name`, `surname`, `avatar`) VALUES(NULL, " +
                            "\'"+(i+1).ToString()+"\', " +
                            "\'emailexample" + (j+1).ToString() + (i+1).ToString() + "@mail.ru\', " +
                            "\'password" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'nickname" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'name" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "\'surname" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "'data/user_avatar/" + (j + 1).ToString() + (i + 1).ToString() + ".png');"
                            );                       
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }

                Random random = new Random();

                for(int i = 1; i <= 80; i++)
                {
                    for (int j = 0; j < 2; j++)
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `project` (`id_project`, `id_user`, `creator`, `name`, `mark`) VALUES(NULL, " +
                            "\'" + i.ToString() + "\', " +
                            "\'"+random.Next(0,2)+"\', " +
                            "\'Project№" + (j + 1).ToString() + (i + 1).ToString() + "\', " +
                            "'#323232');"
                            );
                        // запись массива байтов в файл
                        fstream.Write(array, 0, array.Length);
                    }
                }


                for (int i = 1; i <= 30; i++)
                {
                    // преобразуем строку в байты
                    byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                        "INSERT INTO `attachment` (`id_attach`, `id_project`, `comment`, `date`, `time`) VALUES(NULL, " +
                        "\'"+random.Next(1,161)+"\', " +
                        "\'TextComments"+random.Next(0,90000)+"\', " +
                        "\'"+random.Next(2000,2021)+"-" + random.Next(1,13) + "-" +random.Next(1, 31)+ "\', " +
                        "\'"+random.Next(0,25)+":"+random.Next(0,60)+":00\');"
                        );
                    // запись массива байтов в файл
                    fstream.Write(array, 0, array.Length);
                }

                
                for (int i = 1; i <= 160; i++)
                {
                    for (int j = 1; j <= 3; j++) 
                    {
                        // преобразуем строку в байты
                        byte[] array = System.Text.Encoding.Default.GetBytes("\n" +
                            "INSERT INTO `target` (`id_target`, `id_project`, `name`, `mark`) VALUES(NULL, " +
                            "\'" + i.ToString() + "\', " +
                            "\'NameTarget" + random.Next(0, 90000) + "\', " +
                            "'#121212');"
                            );
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
