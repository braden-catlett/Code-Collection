   M S B A M L   `   `   `  ����M  IAlleleFrequencySim, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null7 clr-namespace:AlleleFrequencySimAlleleFrequencySim  5      &     AlleleFrequencySim.ExternPopForm   5   	   \ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35^ ZWindowsFormsIntegration, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   3allele clr-namespace:AlleleFrequencySim     5      -   5          � Title$  External Population Form��5   	    � SizeToContent$ WidthAndHeight=�6*   $y�	Collapsed=�6I   $��15q�5      .��5      ]� .+�5      ��  �� Orientation$ 
Horizontal=�6   $	��Top=�6(   .+�5	      �� .��6   75Enable the use of these external population settings:6B   �� 5
      -   5        $��EnableExternPop��5
      $��Center=�6%   5      �� 5      $ 
Horizontal=�6   $��Bottom=�6(   .+�5      "   AlleleFrequencySim.SlideText  -   5          Name$ AADistribution��5         
Conversion$
 1000��6.      IsInt .     Minimum$ 0��6N      Maximum$
 1000��6Z      Text$ AA Distribution��6i   	   TickFrequency$		 100��6�     5      -   5        $ AaDistribution��5      $
 1000��6.    .  $ 0��6N   $
 1000��6Z   $ Aa Distribution��6i   $		 100��6�     5      -   5        $ aaDistribution��5      $
 1000��6.    .  $ 0��6N   $
 1000��6Z   $ aa Distribution��6i   $		 100��6�     5      -   5        $ ExposureBegin��5      $ 1��6-   $	 550��69   $ Exposure Begin��6G   $	 55��6]     5      -   5        $ ExposureDuration��5      $ 1��60   $	 550��6<   $ Exposure Duration��6J   $	 55��6c     5      -   5        $ ExposureChance��5      $
 1000��6.    .  $ 0��6N   $
 1000��6Z   $ Exposure Chance��6i   $		 100��6�     5      -	   5        $ MigrationSize��5      $
 1000��6-    .  $ 0��6M   $
 1000��6Y   $ Migration Size��6h   $		 100��6~   5      5      5      