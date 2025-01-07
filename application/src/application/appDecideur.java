package application;

import java.awt.Color;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.DefaultListModel;
import javax.swing.JButton;
import javax.swing.JTextField;

import org.json.JSONException;
import org.json.JSONObject;

import javax.swing.JList;
import javax.swing.JOptionPane;

import java.awt.event.ActionListener;
import java.util.ArrayList;
import java.util.List;
import java.awt.event.ActionEvent;
import javax.swing.JPanel;
import javax.swing.JLayeredPane;
import javax.swing.JLabel;
import javax.swing.JComboBox;

public class appDecideur {

	static private JFrame frame;
	
	private JPanel panelGroupe;
	private JPanel panelProposition;
	private JPanel paneldecider;
	/**
	 * Launch the application.
	 */
	 public static void addPanel(int index) {
 		propScreen propScreen_;
		 try {
			propScreen_ = new propScreen(index);
			propScreen_.setSize(870, 554);
			 propScreen_.setLocation(0, 0);
			 frame.getContentPane().add(propScreen_);

		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		}
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
	 * @throws JSONException 
	 */
	public appDecideur() throws JSONException {
		initialize();
	}

	/**
	 * Initialize the contents of the frame.
	 * @throws JSONException 
	 */
	private void initialize() throws JSONException {
		frame = new JFrame();
		frame.setBounds(100, 100, 870, 554);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.getContentPane().setLayout(null);
		
		JPanel panel = new JPanel();
		panel.setBounds(0, 0, 870, 554);
		panel.setLayout(null);
		
		JLabel lblTitrePropo = new JLabel("Groupes");
		lblTitrePropo.setBounds(26, 15, 235, 13);
		panel.add(lblTitrePropo);
		
		JList<String> groupes;
		List<String> listGroupe = new ArrayList();
		
		JSONObject jsonPropo = connect.con("groupe");
        DefaultListModel<String> model = new DefaultListModel<>();
        for(int i = 0; i<jsonPropo.length(); i++) {
        	
        	JSONObject jsonUti1 = new JSONObject(jsonPropo.getString(String.valueOf(i)));
        		listGroupe.add(jsonUti1.getString("Id_Groupe"));
        		model.addElement(jsonUti1.getString("Nom_Groupe"));

        }
        System.out.println(listGroupe.get(2));
        
        groupes = new JList<>(model);
        groupes.setBounds(44, 82, 500, 180);
        panel.add(groupes);
		
        frame.getContentPane().add(panel);
        
        JButton btnGroupe = new JButton("Sélectionner");
        btnGroupe.addActionListener(new ActionListener() {
        	public void actionPerformed(ActionEvent e) {
        		groupeScreen groupeScreen_;
				try {
					groupeScreen_ = new groupeScreen(Integer.parseInt(listGroupe.get(groupes.getSelectedIndex())));
					groupeScreen_.setSize(870, 554);
					groupeScreen_.setLocation(0, 0);
					panel.setVisible(false);
					frame.getContentPane().add(groupeScreen_);
				} catch (NumberFormatException | JSONException e1) {
					
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
        	}
        }
       
        );
        btnGroupe.setBounds(563, 239, 126, 21);
        panel.add(btnGroupe);
		/*
		
		*/
		
	        
	    
		
		
	}
}
