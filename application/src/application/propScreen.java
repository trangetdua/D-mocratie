package application;

import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;

import org.json.JSONException;
import org.json.JSONObject;
import javax.swing.SwingConstants;
import javax.swing.JTextArea;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.Color;
import java.awt.event.ActionEvent;

public class propScreen extends JPanel{
	public propScreen(int idProp) throws JSONException {

		JSONObject prop = new JSONObject();
		JSONObject jsonPropo = connect.con("Proposition");
        for(int i = 0 ; i<jsonPropo.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonPropo.getString(String.valueOf(i)));
        	if(jsonUti1.getInt("id_proposition")==idProp) {
        		prop = jsonUti1;
        	}
        }
		
		String texteTitre = prop.getString("Titre_Proposition");
		String texteDescription = prop.getString("Description_Proposition");
		setLayout(null);
		JLabel lblInfo = new JLabel(texteTitre);
		lblInfo.setBounds(299, 11, 290, 33);
		add(lblInfo);
		JLabel lblInfo_1 = new JLabel(texteDescription);
		lblInfo_1.setBounds(218, 55, 427, 84);
		add(lblInfo_1);
		
		float budgetActuel = Float.valueOf(prop.getString("evaluation_budgetaire"));
		JLabel lblBudget = new JLabel(String.valueOf(budgetActuel));
		lblBudget.setBounds(149, 150, 126, 14);
		add(lblBudget);
		
		JLabel lblNewLabel = new JLabel("Budget actuel : ");
		lblNewLabel.setBounds(10, 150, 142, 14);
		add(lblNewLabel);
		
		JTextArea textArea = new JTextArea();
		textArea.setBounds(146, 176, 79, 19);
		add(textArea);
		JPanel panel = this;

		JButton btnNewButton = new JButton("Modifier");
		btnNewButton.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
	            int nouveauBudget = Integer.parseInt(textArea.getText());
	            //vérification
	            connect.update("Proposition", "evaluation_budgetaire", "id_proposition", idProp, nouveauBudget);
	            System.out.println("test4");
				JLabel lblNewLabel_1 = new JLabel("Budget modifié. Nouveau budget : "+nouveauBudget);
				lblNewLabel_1.setBounds(195, 136, 221, 14);
				add(lblNewLabel_1);
			}
		
			
		});
		btnNewButton.setBounds(235, 175, 89, 18);
		add(btnNewButton);
		
		
		
		JLabel lblBudget_1 = new JLabel("euros");
		lblBudget_1.setBounds(256, 150, 103, 14);
		add(lblBudget_1);
		
		JLabel lblInfo_2 = new JLabel("Options :");
		lblInfo_2.setBounds(299, 216, 290, 33);
		add(lblInfo_2);
		
		JLabel lblModifierLeBudget = new JLabel("Modifier le budget: ");
		lblModifierLeBudget.setBounds(20, 181, 117, 14);
		add(lblModifierLeBudget);
		int idVote =0;
		JSONObject jsonVote= new JSONObject();
		jsonVote = connect.con("Vote");

        for(int i = 0 ; i<jsonVote.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonVote.getString(String.valueOf(i)));

        	if(jsonUti1.getInt("id_proposition")==idProp) {
        		idVote = jsonUti1.getInt("Id_Vote");
        	}

        }

		JSONObject jsonChoix = connect.con("Choix");
		int variable = 260;
		JLabel lblChoix;
        for(int i = 0 ; i<jsonChoix.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonChoix.getString(String.valueOf(i)));
        	
    		System.out.println("test3");

        	if(jsonUti1.getInt("Id_Vote")==idVote) {
        		String nomChoix = jsonUti1.getString("Nom_Choix");
        		
        		lblChoix= new JLabel(nomChoix);
        		lblChoix.setBounds(262, variable, 221, 33);
        		add(lblChoix);
        		
        		variable = variable-20;

        	}


        }


		

		/*String s = (String)JOptionPane.showInputDialog(
                jFrame,
                texte,
                JOptionPane.PLAIN_MESSAGE
                );
		float bu= Float.parseFloat(s);*/
		//un input pour le budget, un lien avec themes pour les themes
		//lien avec vote et choix et tout 
	}
}
