﻿using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace AppForRegistration
{
    public partial class Form1 : Form
    {
        
        private DataHelper d = new DataHelper();
        public Form1()
        {
            InitializeComponent();
        }

        private void btnGetAll_Click(object sender, EventArgs e)
        {

            lbInfo.Items.Clear();
            foreach (Client c in d.GetAllClients())
            {
                lbInfo.Items.Add(c.ToString());
            }
        }

        private void btAdd_Click(object sender, EventArgs e)
        {
            try
            {
                
                   
                   double accountBalance = Convert.ToDouble(tbAccBalance.Text);
                   //int acc = d.GetNextAccNum();
                   d.AddClient(tbFirstName.Text, tbLastName.Text, tbEmail.Text, Convert.ToChar(tbgender.Text), accountBalance, Convert.ToInt32(tbAge.Text), "in");
                   MessageBox.Show("Successfully added");
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
                
            }
      
           
        }

        private void btsearch_Click(object sender, EventArgs e)
        {
            lbInfo.Items.Clear();
            foreach (Client c in d.GetAllClientsWithStatus(this.tbChangeStatus.Text))
	              {
                      lbInfo.Items.Add(c.ToString());
	              } 
        }

        private void btUpdateStatus_Click(object sender, EventArgs e)
       {
            try
            {
                d.UpdateClientStatus(tbChangeStatus.Text, Convert.ToInt16(tbAccNum.Text));
                this.lbInfo.Items.Add(d.a(Convert.ToInt32(tbAccNum.Text)).ToString());
            }
            catch (Exception EX)
            {

                MessageBox.Show(EX.Message);
            }
          
        }

       
        
    }
}
