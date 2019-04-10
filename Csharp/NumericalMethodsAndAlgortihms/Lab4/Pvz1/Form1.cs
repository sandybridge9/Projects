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
using MathNet.Numerics.LinearAlgebra.Double;
using MathNet.Numerics.LinearAlgebra.Factorization;
//Tadas Laurinaitis
namespace Pvz1
{
    public partial class Form1 : Form
    {
        #region L1
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
        #endregion

        #region Other Methods

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
        #endregion

        #region L2

        // ---------------------------- QR skaida --------------------------------------
        public void QR()
        {
            ClearForm();
            //Pradine x matrica
            Matrix<double> A = DenseMatrix.OfArray(new double[,]
            {
                         {  3,   1,  -1,  1 },
                         {  1,  -2,  3,  1 },
                         {  2,  -9,  5,  2 },
                         {  1,  -7,  2,  1 }
            });
            //po lygybes matrica
            Matrix<double> B = DenseMatrix.OfArray(new double[,]
            {
                          {27},
                          {24},
                          {27},
                          {30}
            });
            richTextBox1.AppendText("Pradinės matricos A ir B: \n");
            richTextBox1.AppendText("A : " + A + "\n");
            richTextBox1.AppendText("B : " + B + "\n");
            Matrix<double> Q = DenseMatrix.OfArray(new double[,]
            {
                     {  1,  0,  0,  0 },
                     {  0,  1,  0,  0 },
                     {  0,  0,  1,  0 },
                     {  0,  0,  0,  1 }
            });
            richTextBox1.AppendText("Pradedamas skaičiavimas \n");
            for (int i = 0; i < 3; i++)
            {
                //Paimam i-taji A matricos stulpeli
                var tempz = A.Column(i).ToArray();
                double[,] temp = new double[tempz.Length - i, 1];
                Matrix<double> z;
                for (int j = 0; j < temp.Length; j++)
                {
                    temp[j, 0] = tempz[j + i];
                }
                //paverciam i matrica
                z = DenseMatrix.OfArray(temp);
                //richTextBox1.AppendText("z: " + z + "\n");
                var zp = DenseMatrix.Build.Dense(z.RowCount, 1);
                zp[0, 0] = Math.Sign(z[0, 0]) * norm(z.Column(0).AsArray());
                //richTextBox1.AppendText("zp : " + zp + "\n");
                var omega = (z - zp);
                omega = omega / omega.FrobeniusNorm();
                var Qi = DenseMatrix.Build.DenseIdentity(4 - i) - 2 * omega * omega.Transpose();
                //richTextBox1.AppendText("Qi: " + Qi + "\n");
                //pirmas ciklas
                if (i == 0)
                {
                    A = Qi * A;
                }
                else
                {
                    var tp = DenseMatrix.Build.Dense(A.RowCount - i, A.RowCount);

                    for (int q = 0; q < 4 - i; q++)
                    {
                        for (int w = 0; w < 4; w++)
                        {
                            tp[q, w] = A[q + i, w];
                        }
                    }

                    tp = Qi * tp;
                    //Atliekami pakeitimai A matricoje
                    for (int q = i; q < 4; q++)
                    {
                        for (int w = 0; w < 4; w++)
                        {
                            A[q, w] = tp[q - i, w];
                        }
                    }
                }
                richTextBox1.AppendText("A: " + A + "\n");
                //pirmas ciklas
                if (i == 0)
                {
                    Q = Q * Qi;
                }
                else
                {
                    var tp = DenseMatrix.Build.DenseIdentity(4, 4);
                    //Atliekami pakeitimai Q matricai
                    for (int q = i; q < 4; q++)
                    {
                        for (int w = i; w < 4; w++)
                        {
                            tp[q, w] = Qi[q - i, w - i];
                        }
                    }
                    Q = Q * tp;
                }

                richTextBox1.AppendText("Q: " + Q + "\n");
            }
            //y=Qt*b
            var bl = Q.Transpose() * B;
            var x = DenseMatrix.Build.Dense(A.ColumnCount, 1);
            // Rx = y => x=y/R
            x[A.ColumnCount - 1, 0] = bl[A.ColumnCount - 1, 0] / A[A.ColumnCount - 1, A.RowCount - 1];
            richTextBox1.AppendText("Laisvųjų nariu stulpelis " + bl + "\n");
            double tiksl = 0.00000001;
            for (int i = 0; i < 4; i++)
            {
                for (int j = 0; j < 4; j++)
                {
                    if (Math.Abs(A[i, j]) <= tiksl)
                    {
                        A[i, j] = 0;
                    }
                }
            }
            for (int i = 0; i < 4; i++)
            {
                if (Math.Abs(bl[i, 0]) <= tiksl)
                    bl[i, 0] = 0;
            }
            richTextBox1.AppendText("R: " + A + "\n");
            double[] ats = new double[4];
            double past = 0;
            bool yra = true;
            for (int i = 3; i >= 0; i--)
            {
                if (A[i, i] == 0 && B[i, 0] - past > 0)
                {
                    richTextBox1.AppendText("SPRENDINIU NERA \n");
                    yra = false;
                    break;
                }
                else if (A[i, i] == 0 && B[i, 0] - past == 0)
                {
                    richTextBox1.AppendText("LABAI DAUG SPRENDINIU \n");
                    yra = false;
                    break;
                }
                if (i == 3)
                {
                    ats[i] = B[i, 0] / A[i, i];
                    past += ats[i];
                }
                else
                {
                    ats[i] = (B[i, 0] - past) / A[i, i];
                    past += ats[i];
                }
            }
            for (int i = 0; i < ats.Length; i++)
            {
                richTextBox1.AppendText("ats: " +ats[i] +"\n");
            }
            if (yra)
                foreach (double atsx in ats)
                    richTextBox1.AppendText(atsx + " \n");
        }
        //Frobenius norm/Euclidean norm of array
        double norm(double[] z)
        {
            double norm = 0;

            for (int i = 0; i < z.Length; i++)
            {
                norm += Math.Pow(z[i], 2);
            }
            norm = Math.Sqrt(norm);

            return norm;
        }

        private void Button10_click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            QR();
        }

        // --------------------------------------- QR skaidos pabaiga ------------------------------------------------------

        // --------------------------------------- Broydenas 2 lygtims ---------------------------------------------------------------

        public void BroydenForTwo()
        {
            ClearForm();

            //max iteraciju skaicius
            int itmax = 10;
            //pozymis rodantis ar sprendinys geras
            //bool isGood = true;
            //pradinis x1 ir x2 artinys
            Matrix<double> x0 = DenseMatrix.OfArray(new double[,]
            {
                          { 2},//x1
                          { 1} //x2
            });
            var xi = x0;
            richTextBox1.AppendText("Pradinis artinys : " + x0 + "\n");
            //Lygciu sistemos matrica
            var ffi = SystemOfEquations(x0);
            //Jakobio matrica
            var a = (Matrix<double>)Jacobian(x0);
            //sprendinio apskaiciavimo tikslumas
            var xi1 = xi - a.Solve(ffi);
            var ffi1 = SystemOfEquations(xi1);
            // kam tas z????
            //var z = Math.Abs(ffi1.);
            for (int i = 0; i <= itmax; i++)
            {
                var s = xi1 - xi;
                richTextBox1.AppendText(" s = " + s + "\n");
                var y = ffi1 - ffi;
                richTextBox1.AppendText(" y = " + y + "\n");
                a = a + (y - a * s) * s.Transpose() / ((s.Transpose() * s)[0, 0]); //* (s * s.Transpose()).Inverse();
                richTextBox1.AppendText(" a = " + a + "\n");
                var xi2 = xi1 - a.Solve(ffi1);
                richTextBox1.AppendText(" xi2 = " + xi2 + "\n");
                var ffi2 = SystemOfEquations(xi2);
                richTextBox1.AppendText(" ffi2 = " + ffi2 + "\n");
                xi = xi1;
                xi1 = xi2;
                ffi = ffi1;
                ffi1 = ffi2;
                richTextBox1.AppendText("Iteracija: " + i + " x = " + xi1 + "\n");
                if (i == itmax)
                {
                    s = xi1;
                    richTextBox1.AppendText("Tikslumas pasiektas, Paskutinis artinys x = " + s + "\n");
                    //isGood = true;
                    break;
                }
            }

        }

        public DenseMatrix SystemOfEquations(Matrix<double> x)
        {
            var f = DenseMatrix.Build.Dense(2, 1);
            f[0, 0] = (Math.Cos(x[0, 0]) - x[0, 0] - x[1, 0]);
            f[1, 0] = (20 * Math.Pow(Math.E, -1 * (Math.Pow(x[0, 0], 2) + Math.Pow(x[1, 0], 2)) / 4) + (Math.Pow(x[0, 0], 2) + Math.Pow(x[1, 0], 2)) / 4 - 10);
            return f as DenseMatrix;

        }
        public DenseMatrix Jacobian(Matrix<double> x)
        {
            var f = DenseMatrix.Build.Dense(2, 2);
            f[0, 0] = -1*Math.Sin(x[0,0])-1;
            f[0, 1] = -1;
            f[1, 0] = (x[0,0]/2) - 10 * x[0,0] * Math.Pow(Math.E, -1 * (x[0,0] / 4));
            f[1, 1] = (x[1,0]/2) - 10 * x[1,0] * Math.Pow(Math.E, -1 * (x[1,0] / 4));
            return f as DenseMatrix;
        }
        private void Button11_click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            BroydenForTwo();
        }
        // --------------------------------------- Broydenas 2 lygtims pabaiga ---------------------------------------------------------------

        // --------------------------------------- Broydenas 4 lygtims -----------------------------------------------------------------------
        public void BroydenForFour()
        {
            ClearForm();

            //max iteraciju skaicius
            int itmax = 10;
            //pozymis rodantis ar sprendinys geras
            bool isGood = true;
            //pradinis x1 ir x2 artinys
            Matrix<double> x0 = DenseMatrix.OfArray(new double[,]
            {
                          { 2},//x1
                          { 3},//x2
                          { 2},//x3
                          { 4} //x2
            });
            var xi = x0;
            richTextBox1.AppendText("Pradinis artinys : " + x0 + "\n");
            //Lygciu sistemos matrica
            var ffi = SystemOfEquations2(x0);
            //Jakobio matrica
            var a = (Matrix<double>)Jacobian2(x0);
            //sprendinio apskaiciavimo tikslumas
            var xi1 = xi - a.Inverse() * ffi;
            var ffi1 = SystemOfEquations2(xi1);

            for (int i = 0; i <= itmax; i++)
            {
                var s = xi1 - xi;
                richTextBox1.AppendText(" s = " + s + "\n");
                var y = ffi1 - ffi;
                richTextBox1.AppendText(" y = " + y + "\n");
                a = a + (y - a * s) * s.Transpose() * (s * s.Transpose()).Inverse();
                richTextBox1.AppendText(" a = " + a + "\n");
                var xi2 = xi1 - a.Inverse() * ffi1;
                richTextBox1.AppendText(" xi2 = " + xi2 + "\n");
                var ffi2 = SystemOfEquations(xi2);
                richTextBox1.AppendText(" ffi2 = " + ffi2 + "\n");
                xi = xi1;
                xi1 = xi2;
                ffi = ffi1;
                ffi1 = ffi2;
                richTextBox1.AppendText("Iteracija: " + i + " x = " + xi1 + "\n");
                if (i == itmax)
                {
                    s = xi1;
                    richTextBox1.AppendText("Tikslumas pasiektas, Paskutinis artinys x = " + s + "\n");
                    isGood = true;
                    break;
                }
            }
        }
        public DenseMatrix SystemOfEquations2(Matrix<double> x)
        {
            var x1 = x[0, 0];
            var x2 = x[1, 0];
            var x3 = x[2, 0];
            var x4 = x[3, 0];
            var f = DenseMatrix.Build.Dense(4, 1);
            f[0, 0] = 2 * x1 + 2 * x2 - x3 + 1;
            f[1, 0] = -5 * Math.Pow(x4, 2) + 4 * x3 * x4 - 4;
            f[2, 0] = -3 * Math.Pow(x3, 2) + Math.Pow(x4, 3) - 2 * x1 * x4 + 3;
            f[3, 0] = 3 * x1 - 6 * x2 + 2 * x3 - 4 * x4 + 44;
            return f as DenseMatrix;

        }
        public DenseMatrix Jacobian2(Matrix<double> x)
        {
            var x1 = x[0, 0];
            var x2 = x[1, 0];
            var x3 = x[2, 0];
            var x4 = x[3, 0];
            Matrix<double> Jacobian = DenseMatrix.OfArray(new double[,]
            {
                          { 2 , 2 , -1 , 0 },
                          { 0 , 0, 4 * x4, -10 * x4 + 4 * x3 },
                          { -2 * x4 , 0, -6 * x3, 12*Math.Pow(x4, 2)},
                          { 3, -6, 2, -4 }
            });

            return Jacobian as DenseMatrix;

        }
        private void Button12_click(object sender, EventArgs e)
        {
            ClearForm();
            PreparareForm(-10, 10, -5, 5);
            BroydenForFour();
        }
        // --------------------------------------- Broydenas 4 lygtims pabaiga ---------------------------------------------------------------
        #endregion

        #region L3

        private double Func(double x)
        {
            return (Math.Log(x) / (Math.Sin(2 * x) + 1.5)) - Math.Cos(x/5);
        }
        // ------------------------ 1 Dalis Niutonas --------------------------------

        private double Newton(double[] X, double[] a, int n, double x)
        {
            double rez = 0;
            for (int i = 0; i < n; i++)
            {
                double temp = 1;
                for (int j = 0; j < i; j++)
                {
                    temp = temp * (x - X[j]);
                }
                rez += a[i] * temp;
            }
            return rez;
        }

        private double[] GetA(double[] X, double[] Y, int N)
        {
            double[,] m = new double[N, N];
            double[] a = new double[N];
            for (int i = 0; i < N; i++)
            {
                m[i, 0] = 1;
            }
            for (int i = 1; i < N; i++)
            {
                for (int j = 1; j <= i; j++)
                {
                    m[i, j] = m[i, j - 1] * (X[i] - X[j - 1]);
                }
            }
            a[0] = Y[0];
            for (int i = 1; i < N; i++)
            {
                double temp = 0;
                for (int j = 0; j <= i; j++)
                {
                    temp += m[i, j];
                }
                a[i] = Y[i] / temp;
            }
            Matrix<double> M = DenseMatrix.Build.Dense(N, N);
            for (int i = 0; i < N; i++)
            {
                for (int j = 0; j < N; j++)
                {
                    M[i, j] = m[i, j];
                }
            }
            richTextBox1.AppendText("" + M);
            Matrix<double> YY = DenseMatrix.Build.Dense(N, 1);
            for (int i = 0; i < N; i++) { YY[i, 0] = Y[i]; }
            Vector<double> YYY = YY.Column(0);
            Vector<double> A = (M.Inverse() * YYY); 
            for (int i = 0; i < N; i++) {
                a[i] = A[i];
            }
            return a;
        }
        //Taskai pagal Ciobysevo abscises
        private void Button13_click(object sender, EventArgs e)
        {
            ClearForm(); // išvalomi programos duomenys
            PreparareForm(0, 10, -4, 6);
            // Nubraižoma f-ja, kuriai ieskome saknies
            Fx = chart1.Series.Add("F(x)");
            Fx.ChartType = SeriesChartType.Line;

            int N = 10;
            double xmax = 10, xmin = 2;
            double temp = 2;
            for (int i = 0; i < N * 10; i++)
            {
                Fx.Points.AddXY(temp, Func(temp));
                temp = temp + 0.1;
            }
            Fx.BorderWidth = 3;

            Series task = chart1.Series.Add("Čiobyševo abscisės");
            task.ChartType = SeriesChartType.Point;

            double[] chyobysev = new double[N];
            double[] Y = new double[N];
            for (int i = 0; i < N; i++)
            {
                chyobysev[i] = ((double)(xmax - xmin) / 2) * Math.Cos(Math.PI * ((double)(2 * i + 1)) / ((double)(2 * N))) + ((double)(xmax + xmin) / 2);
                Y[i] = Func(chyobysev[i]);
                task.Points.AddXY(chyobysev[i], Func(chyobysev[i]));
            }

            Series newton = chart1.Series.Add("Niutono");
            newton.ChartType = SeriesChartType.Line;
            double tempo = 2;
            var a = GetA(chyobysev, Y, N);

            newton.Points.AddXY(2, Y[0]);
            for (int i = 1; i < N * 100; i++)
            {
                newton.Points.AddXY(tempo, Newton(chyobysev, a, N, tempo));
                tempo += 0.1;
            }
            newton.BorderWidth = 3;

            Series nuokrypis = chart1.Series.Add("Nuokrypis");
            nuokrypis.ChartType = SeriesChartType.Line;

            tempo = 2;
            for (int i = 1; i < N * 100; i++)
            {
                nuokrypis.Points.AddXY(tempo, Func(tempo) - Newton(chyobysev, a, N, tempo));
                tempo += 0.1;
            }
            nuokrypis.BorderWidth = 3;
        }
        //Taskai pasiskirste tolygiai
        private void Button14_click(object sender, EventArgs e)
        {
            ClearForm(); // išvalomi programos duomenys
            PreparareForm(0, 10, -4, 6);

            // Nubraižoma f-ja, kuriai ieskome saknies
            Fx = chart1.Series.Add("F(x)");

            Fx.ChartType = SeriesChartType.Line;
            double x = 0;

            int N = 10;

            double xmax = 10, xmin = 2;
            double temp = 2;
            for (int i = 0; i < N * 10; i++)
            {
                Fx.Points.AddXY(temp, Func(temp));
                temp = temp + 0.1;
            }
            Fx.BorderWidth = 3;

            Series task = chart1.Series.Add("Tolygiai pasiskirstę taškai");
            task.ChartType = SeriesChartType.Point;

            double[] Y = new double[N];
            double[] tolygus = new double[N];
            double zingsnis = (xmax - xmin) / N;
            double first = xmin;
            for (int i = 0; i < N; i++)
            {
                tolygus[i] = first + zingsnis * i;
                Y[i] = Func(tolygus[i]);
                task.Points.AddXY(tolygus[i], Func(tolygus[i]));
            }

            Series newton = chart1.Series.Add("Niutono");
            newton.ChartType = SeriesChartType.Line;
            double tempo = 2;
            var a = GetA(tolygus, Y, N);

            newton.Points.AddXY(2, Y[0]);
            for (int i = 1; i < N * 100; i++)
            {
                newton.Points.AddXY(tempo, Newton(tolygus, a, N, tempo));
                tempo += 0.1;
            }
            newton.BorderWidth = 3;

            Series nuokrypis = chart1.Series.Add("Nuokrypis");
            nuokrypis.ChartType = SeriesChartType.Line;

            tempo = 2;
            for (int i = 1; i < N * 100; i++)
            {
                nuokrypis.Points.AddXY(tempo, Func(tempo) - Newton(tolygus, a, N, tempo));
                tempo += 0.1;
            }
            nuokrypis.BorderWidth = 3;
        }

        // ----------------------------- 2 Dalis ---------------------------------------------

        //Daugianaris pagal pirmos lenteles funkcija (Niutonas)
        private void button15_Click(object sender, EventArgs e)
        {
            ClearForm(); // išvalomi programos duomenys
            PreparareForm(0, 16, 22, 28); 

            Series task = chart1.Series.Add("Taskai");
            task.ChartType = SeriesChartType.Point;
            task.MarkerSize = 5;
            task.MarkerStyle = MarkerStyle.Circle;
            task.MarkerColor = Color.Red;

            double[] temperature = { 24.4692, 26.1946, 27.7291, 26.7083, 25.3865, 24.4072, 23.3871, 22.9818, 23.555, 23.8082, 24.7706, 25.1817};
            double[] month = new double[12] { 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 };
            int N = month.Length;
            for (int i = 0; i < month.Length; i++)
            {
                task.Points.AddXY(month[i], temperature[i]);
            }
            Series newton = chart1.Series.Add("Niutono");
            newton.ChartType = SeriesChartType.Line;
            double tempo = 1;
            var a = GetA(month, temperature, N);

            // newton.Points.AddXY(month[0], temperature[0]);
            for (int i = 1; i < N * 100; i++)
            {
                newton.Points.AddXY(tempo, Newton(month, a, N, tempo));
                newton.Points.AddXY(tempo, Newton(month, a, N, tempo));
                newton.Points.AddXY(tempo, Newton(month, a, N, tempo));
                tempo += 0.1;
            }
            newton.BorderWidth = 3; 
        }

        // ----------------------------- 4 Dalis ---------------------------------------------
        private void button16_Click(object sender, EventArgs e)
        {
            ClearForm(); // išvalomi programos duomenys
            //PreparareForm(0, 16, 18, 35);//deivio
            PreparareForm(0, 16, 22, 28); //mano

            Series task = chart1.Series.Add("Taskai");
            Series kreive = chart1.Series.Add("Kreive");
            kreive.ChartType = SeriesChartType.Line;
            task.ChartType = SeriesChartType.Point;
            task.MarkerSize = 5;
            task.MarkerStyle = MarkerStyle.Circle;
            task.MarkerColor = Color.Red;
            //double[] temperature = { 19.8794, 23.7751, 27.883, 31.0976, 33.2133, 33.8218, 31.8081, 29.8617, 29.1279, 28.8316, 25.9363, 21.4918 }; //deivio
            double[] temperature = { 24.4692, 26.1946, 27.7291, 26.7083, 25.3865, 24.4072, 23.3871, 22.9818, 23.555, 23.8082, 24.7706, 25.1817 };//mano
            double[] month = new double[12] { 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 };
            double[] a = mkm(2, month, temperature); //pirmas parametras - polinomo eile
            for (int i = 0; i < a.Length; i++)
            {
                richTextBox1.AppendText(a[i].ToString());
            }
            int N = 100;
            double dx = (12.0 - 1) / (N - 1);
            for (int i = 0; i < N; i++)
            {
                kreive.Points.AddXY(1 + i * dx, func2(a, 1 + i * dx));
                //func2(a, i * dx);
            }
            for (int i = 0; i < month.Length; i++)
            {
                task.Points.AddXY(month[i], temperature[i]);
            }
        }

        double[] mkm(int n, double[] x, double[] y)
        {
            int m = x.Length;
            double[,] pa = new double[m, 2 * n + 1];
            double[,] pxy = new double[m, n + 1];
            double[] xk = new double[m];
            for (int i = 0; i < m; i++)
            {
                xk[i] = 1;
            }
            for (int j = 0; j < 2 * n + 1; j++)
            {
                for (int i = 0; i < m; i++)
                {
                    pa[i, j] = xk[i];
                }
                if (j < n + 1)
                {
                    for (int i = 0; i < m; i++)
                    {
                        pxy[i, j] = xk[i] * y[i];
                    }
                }
                for (int i = 0; i < m; i++)
                {
                    xk[i] = xk[i] * x[i];
                }
            }
            double[] s = new double[2 * n + 1];
            for (int i = 0; i < 2 * n + 1; i++)
            {
                double temp = 0;
                for (int j = 0; j < m; j++)
                {
                    temp += pa[j, i];
                }
                s[i] = temp;
            }
            double[] b = new double[n + 1];
            for (int i = 0; i < n + 1; i++)
            {
                double temp = 0;
                for (int j = 0; j < m; j++)
                {
                    temp += pxy[j, i];
                }
                b[i] = temp;
            }
            double[,] c = new double[n + 1, n + 1];
            for (int i = 0; i < n + 1; i++)
            {
                for (int j = 0; j < n + 1; j++)
                {
                    c[i, j] = s[i + j];
                }
            }
            Matrix<double> cm = DenseMatrix.OfArray(c);
            Vector<double> bm = Vector.Build.DenseOfArray(b);
            Vector<double> a = cm.Solve(bm);
            richTextBox1.AppendText(cm.ToString());
            richTextBox1.AppendText(bm.ToString());
            richTextBox1.AppendText(a.ToString());
            double[] array = new double[n + 1];
            for (int i = 0; i < n + 1; i++)
            {
                array[i] = a[i];
            }
            return array;
        }

        double func2(double[] array, double x)
        {
            double sum = 0;
            for (int i = 0; i < array.Length; i++)
            {
                sum += array[i] * Math.Pow(x, i);
            }
            return sum;
        }
        #endregion
    }
}
