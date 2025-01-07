package application;

import javax.swing.JPanel;
import javax.swing.SwingUtilities;

import org.json.JSONException;
import org.json.JSONObject;

import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.*;

import javax.swing.DefaultListModel;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JList;
import javax.swing.JOptionPane;
import javax.swing.JTextArea;


public class groupeScreen extends JPanel {

	public void invi(){
    	this.setVisible(false);
    }

	private static final long serialVersionUID = 1L;
	private JList<String> propos;
	String Titre;
	String description;
	List<String> listPropo = new ArrayList();
	int eval_Budgetaire;
	int votant;
	
	/**
	 * Create the panel.
	 */
	public groupeScreen(int idGroupe) throws JSONException {
    	

		JSONObject jsonPropo = connect.con("Proposition");
		
		
        //créer le modèle et ajouter des éléments
    	
		  //System.out.println(jsonUti1.getString("Mail_Utilisateur"));
        DefaultListModel<String> model = new DefaultListModel<>();
    	
        for(int i = 0 ; i<jsonPropo.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonPropo.getString(String.valueOf(i)));
        	int groupe = Integer.parseInt(jsonUti1.getString("Id_Groupe"));
        	
        	if(groupe == idGroupe) {
        		listPropo.add(jsonUti1.getString("id_proposition"));
        		model.addElement(jsonUti1.getString("Titre_Proposition"));
        	}
        }
        JButton bntAlgo = new JButton("Algorithme");
        bntAlgo.setBounds(640, 11, 184, 21);
		setLayout(null);
		
		
		
		
		JLabel lblTitrePropo = new JLabel("Propositions votées");
		lblTitrePropo.setBounds(26, 15, 235, 13);
		add(lblTitrePropo);
		
		JComboBox comboBoxAlgo = new JComboBox();
		comboBoxAlgo.setBounds(650, 30, 168, 21);
		add(comboBoxAlgo);
		comboBoxAlgo.setVisible(false);
		
		bntAlgo.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				comboBoxAlgo.setVisible(true);
				
			}
		});
		add(bntAlgo);
		
		
		
		JLabel lblBudget = new JLabel("Budget total du groupe :");
		lblBudget.setBounds(36, 40, 184, 13);
		add(lblBudget);

		JSONObject jsonGroupes = connect.con("groupe");
		JSONObject grp = new JSONObject();
        for(int i = 0 ; i<jsonGroupes.length(); i++) {
        	JSONObject groupe = new JSONObject(jsonGroupes.getString(String.valueOf(i)));
        	if(groupe.getInt("Id_Groupe")==idGroupe) {
        		grp = groupe;
        	}
        }

		float budgetActuel = Float.valueOf(grp.getString("Limite_Budget_Global"));
		JLabel lblBudgetdef = new JLabel(String.valueOf(budgetActuel));
		lblBudgetdef.setBounds(202, 39, 89, 14);
		add(lblBudgetdef);
 
        //créer la liste 
        propos = new JList<>(model);
        propos.setBounds(44, 82, 500, 230);
        add(propos);
        
        
              
        this.setBounds(100, 100, 870, 554);
        this.setSize(870, 554);
        JPanel panel = this;
        JButton btnInfo = new JButton("En savoir plus");
        btnInfo.addActionListener(new ActionListener() {
        	public void actionPerformed(ActionEvent e) {
        		for( int i =0; i<propos.getSelectedValuesList().size() ; i++  ) {
        		//	JFrame jFrame = new JFrame();
        			String index = listPropo.get(propos.getSelectedIndex());
            		propScreen propScreen_;

        			
        				/*propScreen_ = new propScreen(Integer.parseInt(index));
    					propScreen_.setSize(870, 554);
    					propScreen_.setLocation(0, 0);*/
    					panel.setVisible(false);
    					/*jFrame.getContentPane().add(propScreen_);
    					jFrame.setBackground(Color.BLACK);*/
    					appDecideur.addPanel(Integer.parseInt(index));
        		
        		}
        		
        	}
        });
        btnInfo.setBounds(640, 131, 178, 21);
        add(btnInfo);
        
        JTextArea textArea = new JTextArea();
        textArea.setBounds(289, 32, 106, 22);
        add(textArea);
        
        JButton btnNewButton = new JButton("Modifier");
        
        btnNewButton.addActionListener(new ActionListener() {
        	public void actionPerformed(ActionEvent e) {
        		//put
        		//connect.update("groupe",, , , );
        		JLabel lblBudget = new JLabel("Budget modifié. Nouveau budget :");
        		lblBudget.setBounds(170, 49, 106, 22);
        		add(lblBudget);

        	}
        });
        btnNewButton.setBounds(407, 33, 89, 23);
        add(btnNewButton);
        this.setVisible(true);
	}
	
	  public static void main(String[] args) 
	    {
	        SwingUtilities.invokeLater(new Runnable() 
	        {
	            @Override
	            public void run() 
	            {
	                try {
	                	System.out.println("djdj");
						new groupeScreen(1);
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
	            }
	        });
	    }   
}
