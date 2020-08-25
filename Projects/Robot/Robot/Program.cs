using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NKH.MindSqualls;
using NKH.MindSqualls.HiTechnic;

namespace Robot
{
    class Program
    {
        public static NxtBrick brick = new NxtBrick(NxtCommLinkType.Bluetooth,5);
        public static NxtMotor left = new NxtMotor();
        public static NxtMotor right = new NxtMotor();
        public static NxtMotor whack = new NxtMotor();
        public static NxtMotorSync pair = new NxtMotorSync(left, right);

        public static HiTechnicColorSensor ball = new HiTechnicColorSensor();
        public static NxtUltrasonicSensor eyes = new NxtUltrasonicSensor();

        private static bool raised = false;

        public static sbyte Speed = -50;
        static void Main(string[] args)
        {
            ball.PollInterval = 40;
            eyes.PollInterval = 40;
            Console.WriteLine("Polling Intervals set");

            brick.MotorA = left;
            brick.MotorB = right;
            brick.MotorC = whack;
            brick.Sensor3 = ball;
            brick.Sensor4 = eyes;
            Console.WriteLine("Sensors and Motors Assigned");

            eyes.ThresholdDistanceCm = 30;
            Console.WriteLine("Ultrasonic Threshold Distance set to " + 30);

            ball.OnPolled += new Polled(ball_OnPolled);
            eyes.OnPolled += new Polled(eyes_thePoll);
            eyes.OnWithinThresholdDistanceCm += eyes_OnPolled;
            eyes.OnOutsideThresholdDistanceCm += new NxtSensorEvent(eyes_OnOutsideThresholdDistanceCm);
            Console.WriteLine("Polling event handlers and Threshold Distance handlers set");

            brick.InitSensors();
            Console.WriteLine("Sensors Initialized");

            brick.Connect();
            Console.WriteLine("Connection Established\n\nCommencing Experiment");

            eyes.ContinuousMeasurementCommand();

            pair.Run(Speed, 0, 0);

            Console.ReadKey();
            brick.Disconnect();

        }
        static void eyes_thePoll(NxtPollable s)
        {
            NxtUltrasonicSensor st = (NxtUltrasonicSensor)s;
            if (st.DistanceCm <= 10)
            {
                Console.WriteLine("Something is very close");
                //pair.Idle();
                //pair.Brake();
                pair.Run(50, 100, 0);
                pair.ResetMotorPosition(true);
            }
            else
                return;
        }
        static void eyes_OnOutsideThresholdDistanceCm(NxtSensor sensor)
        {
            NxtUltrasonicSensor s = (NxtUltrasonicSensor)sensor;
            Console.WriteLine("All Clear: Moving Forward");
            pair.Idle();
            pair.Brake();
            pair.Run(Speed, 0, 0);
            pair.ResetMotorPosition(true);
        }

        static void eyes_OnPolled(NxtSensor polledItem)
        {
            NxtUltrasonicSensor eyes = (NxtUltrasonicSensor) polledItem;
            Random r = new Random();
            if (ball.RedReading() >= (byte)35)
            {
                return;
            }
            Console.WriteLine("Object found: " + eyes.DistanceCm.ToString() + " *Turning*");
            if (r.Next(100) > 70)
            {
                pair.Idle();
                pair.Brake();
                left.Run(50, 800);
            }
            else
            {
                pair.Idle();
                pair.Brake();
                right.Run(50, 400);
            }
            pair.ResetMotorPosition(true);
        }
        
        static void ball_OnPolled(NxtPollable polledItem)
        {
            HiTechnicColorSensor ball = ((HiTechnicColorSensor)polledItem);
            if (ball.RedReading() == null)
            {
                if (raised)
                {
                    whack.ResetMotorPosition(true);
                    whack.Run(100, 50);
                    raised = false;
                }
                //pair.Run(Speed, 0, 0);
                return;
            }
            if (ball.RedReading() > (byte)35)
            {
                pair.Idle();
                pair.Brake();
                System.Threading.Thread.Sleep(500);
                raised = true;
                whack.Run(-100, 50);
                System.Threading.Thread.Sleep(2000);
            }
        }
    }
}
