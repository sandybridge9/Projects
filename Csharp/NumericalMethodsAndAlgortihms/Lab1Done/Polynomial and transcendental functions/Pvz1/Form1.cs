using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Windows.Forms.DataVisualization.Charting;
using MathNet.Numerics.LinearAlgebra;
using MathNet.Numerics.LinearAlgebra.Factorization;
//Tadas Laurinaitis
namespace Pvz1
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            Initialize();
        }

        float x1, x2; // x1 - the beggining x2 - the end of the isolation interval
        int iii; // iteration number
        double currentStep; // current step size used in iterations

        Series Fx, Root; // Fx - graph of the function, Root - used to mark roots

        //Polynomial function
        private double F(double x)
        {
            return (double)(-0.45 * Math.Pow(x, 4) + 1.04 * Math.Pow(x, 3) + 1.42 * Math.Pow(x, 2) - 2.67 * x - 0.97);
        }
        //Transcendental function
        private double G(double x)
        {
            return (double)(Math.Pow(Math.E, Math.Sin(x)) - (x/10));
        }

        //Function of volume(V) which is directly dependant on height(h) of the liquid - V(h) = (PI*r^2*h)/2+(r^2*sin(8*PI*h))/16 <--- where r = 0.4m, V = 0.025m^3
        private double V(double h)
        {
            return (double)(((Math.PI*Math.Pow(0.4,2)*h)/2)+((Math.Pow(0.4,2)*Math.Sin(8*Math.PI*h))/16));
        }

        /// <summary>
        /// A function which selects which method to use
        /// </summary>
        /// <param name="start"></param>
        /// <param name="end"></param>
        /// <param name="step"></param>
        /// <param name="functionNumber">1 - ScannerMethod, 2 - ChordsMethod, 3 - SecantMethod</param>
        /// <param name="function"></param>
        private void FindRoots(double start, double end, double step, int functionNumber, Func<double, double> function)
        {
            for (double i = start; i <= end; i += step)
            {
                if (Math.Sign(function(i)) != Math.Sign(function(i + step)))
                {
                    if (functionNumber == 1)
                    {
                        ScannerMethod(i, i + step, step, function);
                    }
                    else if (functionNumber == 2)
                    {
                        ChordsMethod(i, i + step, 5, function);
                    }
                    else if (functionNumber == 3)
                    {
                        int iter = 0;
                        SecantMethod(ref i, ref iter, function);
                        Root.Points.AddXY(i, 0);
                    }
                }
            }
            richTextBox1.AppendText("The Calculations are finished.");
        }
        /// <summary>
        /// A function which iterates over the selected interval of values and checks if the sign of current value is the same as the sign of value which comes after the next step.
        /// If the signs are different, then the step size is cut by half, and the iteration continues. After a fixed iteration count, the function prints out the value.
        /// </summary>
        /// <param name="start"></param>
        /// <param name="end"></param>
        /// <param name="step"></param>
        /// <param name="function"></param>
        private void ScannerMethod(double start, double end, double step, Func<double, double> function)
        {
            float x = (float)start; //starting point
            iii = 0; //iteration number
            //while x is in the selected interval
            while (x < end)
            {
                //if signs are different then cut the step by half
                if (Math.Sign(function(x + step)) != Math.Sign(function(x)))
                {
                    step = step * 0.5;
                    iii++;
                }
                //if sign stays the same, proceed to the next step
                else
                {
                    x += (float)step;
                }
                //after a number (iii) of iterations, print the result
                if (iii == 13)
                {
                    Root.Points.AddXY(x, 0);
                    richTextBox1.AppendText("Function value is: " + function(x) + " when x equals: " +x +"\n");
                    break;
                }
            }
        }
        /// <summary>
        /// A function which 
        /// </summary>
        /// <param name="start"></param>
        /// <param name="end"></param>
        /// <param name="times"></param>
        /// <param name="function"></param>
        private void ChordsMethod(double start, double end, int times, Func<double, double> function)
        {
            double k = 0;
            double xMid = 0;

            for (int i = 0; i < times; i++)
            {
                k = Math.Abs(function(start) / function(end));
                xMid = ((start + k * end) / (1 + k));
                if (Math.Sign(function(start)) == Math.Sign(function(xMid)))
                {
                    start = xMid;
                }
                else
                {
                    end = xMid;
                }
            }
            Root.Points.AddXY(xMid, 0);
            richTextBox1.AppendText("Function value is: " + function(xMid) + " when x equals: " + xMid + "\n");
        }

        private void SecantMethod(ref double start, ref int iterations, Func<double, double> function)
        {
            double h = 0.001;
            double prev;
            while (Math.Abs(function(start)) > 1e-9 && iterations < 250)
            {
                prev = start;
                start = start - Math.Pow(((function(start) - function(start - h)) / h), -1) * function(start);
                h = start - prev;
                iterations++;
            }
            richTextBox1.AppendText("Function value is: " + function(start) + " when x equals: " + start + "\n");
            Root.Points.AddXY(start, 0);
        }

        //button3_Click - button9_Click methods solve F(x) and G(x) in 3 different ways and solve V(h) using SecantMethod
        private void button3_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            x1 = -2;
            x2 = 4;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("F(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = -3;
            for (int i = 0; i < 100; i++)
            {
                Fx.Points.AddXY(x, F(x));  x = x + (2 * Math.PI) /50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 1, F);
        }

        private void button4_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            x1 = -2; 
            x2 = 4;
            iii = 0; 
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("F(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = -3;
            for (int i = 0; i < 100; i++)
            {
                Fx.Points.AddXY(x, F(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 2, F);
        }

        private void button5_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            x1 = -2;
            x2 = 4;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("F(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = -3;
            for (int i = 0; i < 100; i++)
            {
                Fx.Points.AddXY(x, F(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 3, F);
        }

        private void button6_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(0, 20, -2, 10);
            x1 = 1;
            x2 = 15;
            //drawing of X and Y axis
            Fx = chart1.Series.Add("X axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = 0; i < 22; i++)
            {
                Fx.Points.AddXY(i, 0);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            Fx = chart1.Series.Add("Y axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = -2; i < 10; i++)
            {
                Fx.Points.AddXY(0, i);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("G(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = 0;
            for (int i = 0; i < 500; i++)
            {
                Fx.Points.AddXY(x, G(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 1, G);
        }

        private void button7_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(0, 20, -2, 10);
            x1 = 1;
            x2 = 15;
            // drawing of X and Y axis
            Fx = chart1.Series.Add("X axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = 0; i < 22; i++)
            {
                Fx.Points.AddXY(i, 0);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            Fx = chart1.Series.Add("Y axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = -2; i < 10; i++)
            {
                Fx.Points.AddXY(0, i);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("G(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = 0;
            for (int i = 0; i < 500; i++)
            {
                Fx.Points.AddXY(x, G(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 2, G);
        }

        private void button8_Click(object sender, EventArgs e)
        {
            ClearForm(); 
            PreparareForm(0, 20, -2, 10);
            //drawing of X and Y axis
            x1 = 1; 
            x2 = 15; 
            Fx = chart1.Series.Add("X axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = 0; i < 22; i++)
            {
                Fx.Points.AddXY(i, 0);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            Fx = chart1.Series.Add("Y axis");
            Fx.ChartType = SeriesChartType.Line;
            for (int i = -2; i < 10; i++)
            {
                Fx.Points.AddXY(0, i);
            }
            Fx.Color = Color.Black;
            Fx.BorderWidth = 2;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("G(x)");
            Fx.ChartType = SeriesChartType.Line;
            double x = 0;
            for (int i = 0; i < 500; i++)
            {
                Fx.Points.AddXY(x, G(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 3, G);
        }

        private void button9_Click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-0.5f, 0.5f, -0.25f, 0.25f);
            x1 = -0.5f;
            x2 = 0.5f;
            iii = 0;
            currentStep = 0.25f;
            richTextBox1.AppendText("The beggining of the isolation interval is: " + x1 + " the end of the isolation interval is: " + x2 + " Step size: " + currentStep + "\n");
            // The function, the roots of which we need to find, is drawn
            Fx = chart1.Series.Add("V(h)");
            Fx.ChartType = SeriesChartType.Line;
            double x = -50;
            for (int i = 0; i < 500; i++)
            {
                Fx.Points.AddXY(x, V(x)); x = x + (2 * Math.PI) / 50;
            }
            Fx.BorderWidth = 3;
            Root = chart1.Series.Add("Root");
            Root.Color = Color.Red;
            Root.MarkerStyle = MarkerStyle.Circle;
            Root.MarkerSize = 8;
            FindRoots(x1, x2, currentStep, 3, V);
        }        


        //-------------------Other Methods------------------------------

        /// <summary>
        /// Uždaroma programa
        /// </summary>
        private void button1_Click(object sender, EventArgs e)
        {
            Close();
        }
        
        /// <summary>
        /// Išvalomas grafikas ir consolė
        /// </summary>
        private void button2_Click(object sender, EventArgs e)
        {
            ClearForm();
        }
        
        public void ClearForm()
        {
            richTextBox1.Clear(); // isvalomas richTextBox1
            // isvalomos visos nubreztos kreives
            chart1.Series.Clear();
        }
    }
}
