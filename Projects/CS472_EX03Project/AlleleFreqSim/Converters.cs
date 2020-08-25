using System;
using System.Globalization;
using System.Windows.Data;

namespace AlleleFrequencySim
{
	public class ExposureDurationConverter : IValueConverter
	{
		public object Convert(object value, Type targetType, object parameter, CultureInfo culture)
		{
			return (int) 550 - ((double) value) * 55;
		}

		public object ConvertBack(object value, Type targetType, object parameter, CultureInfo culture)
		{
			throw new NotImplementedException();
		}
	}
}
