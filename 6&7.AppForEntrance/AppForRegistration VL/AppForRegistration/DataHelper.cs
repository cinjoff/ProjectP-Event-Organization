using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using MySql.Data.MySqlClient;

namespace AppForRegistration
{
    class DataHelper
    {
     
        private MySqlConnection connection;
        List<Client> clientlist;

        public DataHelper()
        {
            clientlist = new List<Client>();
            String connectionInfo = "server=athena01.fhict.local;"
                        + "database=dbi251195;"
                        + "User id=dbi251195;"
                        + "password=GME7PlrdGQ;"
                        + "connect timeout=30;";

            connection = new MySqlConnection(connectionInfo);
        }


        public List<Client> GetAllClients()
        {
            String sql = "SELECT * FROM Client";
            MySqlCommand command = new MySqlCommand(sql, connection);
            clientlist = new List<Client>();
            try
            {
                connection.Open();
                MySqlDataReader reader = command.ExecuteReader();
     
                while (reader.Read())
                {
                    int accountNum =  Convert.ToInt32(reader[0]);
                    string firstName = reader[1].ToString();
                    int age = Convert.ToInt32(reader[2]);
                    //int reservationNum =  Convert.ToInt32(reader[3]);
                    string lastName =  reader[3].ToString();
                    char gender = Convert.ToChar(reader[4]);
                    string email =  reader[5].ToString();
                    double accountBalance =  Convert.ToDouble(reader[6]);
                    string status = reader[7].ToString();

                    Client temp = new Client(accountNum, firstName, lastName, email, gender, accountBalance - Client.entranceFee, age, status);
                    if (temp.Status == "in")
                    {
                        temp.ChargeBalance(Client.entranceFee);
                        clientlist.Add(temp);
                    }
                    else if (temp.Status == "reserved")
                    {
                        clientlist.Add(temp);
                    }
                    else if (temp.Status == "out")
                    {
                        temp.ChargeBalance(Client.entranceFee);
                        clientlist.Add(temp);
                    }
                    
                }
            }
            catch (Exception ex)
            {
                System.Windows.Forms.MessageBox.Show(ex.Message);
            }
            finally
            {
                connection.Close();
            }
            return clientlist;
        }

        public List<Client> GetAllClientsWithStatus(String status)
        {
            List<Client> templist = new List<Client>();
            foreach (Client client in clientlist)
            {
                if (client.Status == status)
                    templist.Add(client);

            }
            return templist;
        }

       


        public int UpdateClientStatus(string status,int accNum)
        {
            String sql = "UPDATE client SET Status="+ "'"+status+"'" + 
            "WHERE EventAccount ="+ accNum ; 
            MySqlCommand command = new MySqlCommand(sql, connection);


            try
            {

                connection.Open();
                int number = Convert.ToInt32(command.ExecuteScalar());
                return number;
            }
            catch (FormatException)
            {
                return -1;
            }
            finally
            {
                connection.Close();
            }

        }


        public void AddClient(string firstName, string lastName, string email, char gender, double accountBalance, int age, string status)
        {
            String sql = "INSERT INTO client(FirstName,Age, LastName,gender,Email,AccountBalance,Status) VALUES ('" + firstName + "'," + age + "," + "'" + lastName + "','" + gender + "','" + email + "'," + accountBalance + ",'" + status + "')";
            MySqlCommand command = new MySqlCommand(sql, connection);
            try
            {

                connection.Open();
                command.ExecuteReader();
            }
            catch(FormatException)
            {
                throw;
            }
            finally
            {
                connection.Close();
            }
        }


        public Client getClient(int accnum)
        {
            foreach (Client c in clientlist)
            {
                if (c.AccountNum == accnum)
                {
                    return c;
                }
            }
            return null;
        }

        public int GetNextAccNum()
        {

            String sql = "SELECT COUNT(*) FROM client";
            MySqlCommand command = new MySqlCommand(sql, connection);
            int number = 0;
            try
            {
                connection.Open();
                number = Convert.ToInt32(command.ExecuteScalar());
                number++;
                return number;
            }
            catch
            {
                return -1;

            }
            finally
            {
                connection.Close();
            }
            
        }

        public Client a(int acc)
        {
            string balance = "Select * From Client WHERE EventAccount = " + acc + ";";
            MySqlCommand command = new MySqlCommand(balance, connection);
            int AccountNumber;
            string Firstname;
            int birth;
            string Lastname;
            char gender;
            string email;
            double Accountbalance;
            string status;
            Client temp;

            try
            {
                connection.Open();
                MySqlDataReader reader = command.ExecuteReader();
                while (reader.Read())
                {
                    AccountNumber = Convert.ToInt32(reader[0]);
                    Firstname = Convert.ToString(reader[1]);
                    birth = Convert.ToInt32(reader[2]);
                    Lastname = Convert.ToString(reader[3]);
                    gender = Convert.ToChar(reader[4]);
                    email = Convert.ToString(reader[5]);
                    Accountbalance = Convert.ToDouble(reader[6]);
                    status = Convert.ToString(reader[7]);
                    temp = new Client(AccountNumber, Firstname, Lastname, email, gender, Accountbalance, birth, status);
                    return temp;
                }
                return null;

            }
            catch (Exception)
            {
                return null;
            }
            finally
            {
                connection.Close();
            }
        }
     

    }
}
    

