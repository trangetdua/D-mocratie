package application;

import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JButton;
import javax.swing.JTextField;
import javax.swing.JList;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JPanel;
import javax.swing.JLayeredPane;
import javax.swing.JLabel;
import javax.swing.JComboBox;

public class appDecideur {

	private JFrame frame;
	
	private JPanel panelGroupe;
	private JPanel panelProposition;
	private JPanel paneldecider;
	/**
	 * Launch the application.
	 */
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
					appDecideur window = new appDecideur();
					window.frame.setVisible(true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}

	/**
	 * Create the application.
	 */
	public appDecideur() {
		initialize();
	}

	/**
	 * Initialize the contents of the frame.
	 */
	private void initialize() {
		frame = new JFrame();
		frame.setBounds(100, 100, 450, 300);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.getContentPane().setLayout(null);
		
		JButton btnNewButton = new JButton("New button");
		btnNewButton.setBounds(79, 114, 297, -70);
		frame.getContentPane().add(btnNewButton);
		
		JButton changePage = new JButton("Algorithme");
		
		
		
		changePage.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				JPanel panel = new JPanel();
				panel.setBounds(0, 0, 436, 253);
				frame.getContentPane().add(panel);
				
			}
		});
		changePage.setBounds(327, 17, 85, 21);
		frame.getContentPane().add(changePage);
		
		JList list = new JList();
		list.setBounds(56, 85, 0, 1);
		frame.getContentPane().add(list);
		
		
		JLabel lblNewLabel = new JLabel("New label");
		lblNewLabel.setBounds(10, 10, 168, 23);
		frame.getContentPane().add(lblNewLabel);
		
		JComboBox comboBox = new JComboBox();
		comboBox.setBounds(327, 48, 85, 21);
		frame.getContentPane().add(comboBox);
		
		
	}
}
