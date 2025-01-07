package application;

import java.awt.event.ActionEvent; 
import java.awt.event.ActionListener;

import javax.swing.*;

public class SimpleGUI {
	public static void main(String[] args) { 
        // Create the main frame 
        JFrame frame = new JFrame("Simple GUI"); 
        frame.setSize(400, 300); 
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE); 
 
        // Add a label 
        JLabel label = new JLabel("Hello, World!", SwingConstants.CENTER); 
        frame.add(label); 
 
        // Add a button 
        JButton button = new JButton("Click Me"); 
        frame.add(button, "South"); 
 
        // Add a click event to the button 
        button.addActionListener(new ActionListener() { 
            @Override 
            public void actionPerformed(ActionEvent e) { 
                label.setText("Button Clicked!"); 
            } 
        }); 
 
        // Make the frame visible 
        frame.setVisible(true); 
    } 
}
