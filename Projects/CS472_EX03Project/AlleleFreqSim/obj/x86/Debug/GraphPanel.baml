   M S B A M L   `   `   `  ����M  IAlleleFrequencySim, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null7 clr-namespace:AlleleFrequencySimAlleleFrequencySim  5      #clr-namespace:ZedGraphZedGraph  5      #    AlleleFrequencySim.GraphPanel   5      \ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35^ ZWindowsFormsIntegration, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     5      R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5      Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5      @d2http://schemas.microsoft.com/expression/blend/2008     5      3allele clr-namespace:AlleleFrequencySim     5      +zedgraphclr-namespace:ZedGraph     5      -   5        .��5	      �� 
�������$��1q�6   ._�5
      �� .+�5      ]� $��Center=�6   .+�5      "   AlleleFrequencySim.SlideText  -   5           Name$  	fitnessAA��5         
Conversion$
 1000��6*      IsInt .     Minimum$ 0��6J      Maximum$
 1000��6V      Text$ 
Fitness AA��6e      TickFrequency$	 100��6w     5      -   5        $  	fitnessAa��5      $
 1000��6*    .  $ 0��6J   $
 1000��6V   $ 
Fitness Aa��6e   $	 100��6w     5      -   5        $  	fitnessaa��5      $
 1000��6*    .  $ 0��6J   $
 1000��6V   $ 
Fitness aa��6e   $	 100��6w     5      -   5        $  mutationRateFromA��5      $ -9��62   $ -2��6?      
IsReadOnly . $ A to a Mutn. Rate��6^     5      -   5        $  mutationRateToA��5      $ -9��60   $ -2��6=    . $ a to A Mutn. Rate��6\     5      -   5        $  initAlleleFrequency��5      $
 1000��64    .  $ 0��6T   $
 1000��6`   $ Init. Allele Freq.��6o   $	 100��6�     5      -   5        $  popSize��5      $ 10��6(   $
 5000��65      
StartValue$	 500��6D   $ 	Pop. Size��6U   $	 500��6f     5      -	   5        $  
generation��5      $	 100��6+   $
 1000��69   $ Gen. Number��6H   $ 90��6[   5      � 5      	 � ColumnDefinitions	 5      �� 5      �� 5      .+�5!      �� -
   5        $��noMutationFromA��5!      $��0��6   $��Right=�66   .��6R   0 MR6X   �� 5"      -   5        $��noMutationToA��5"      $��1��6   $
��Left=�64   $��5 0 0 0q�6O   .��6`   0 MR6f   5#      7  1System.Windows.Forms.Integration.WindowsFormsHost  5$      $	��600��6   $	��350��6"   
   Child.
 5%         ZedGraph.ZedGraphControl  -   5        graphControl��[ WSystem.Windows.Forms, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089"  System.Windows.Forms.Control   Width$	 600��5%   5      Height$	 350��6A   5&      5'      5(      5)      