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
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.awt.Color;
import java.awt.event.ActionEvent;

public class propScreen extends JPanel{
	public propScreen(int idProp) throws JSONException {
		System.out.println("test1");
		List<String> themes = new ArrayList<>();
		JSONObject prop = new JSONObject();
		JSONObject Theme1 = new JSONObject();
		JSONObject Theme2 = new JSONObject();
		Theme2 =null;
		
		int nb = 0;
		JSONObject jsonThemePoste = connect.con("theme_poste");
		for(int i = 0 ; i<jsonThemePoste.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonThemePoste.getString(String.valueOf(i)));
        	if(jsonUti1.getInt("id_proposition")==idProp) {
        		
        		themes.add(jsonUti1.getString("Id_Theme"));
        	}
        }

		JSONObject jsonTheme = connect.con("Thème");
		boolean T2Existe = false;
		for(int i = 0 ; i<jsonTheme.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonThemePoste.getString(String.valueOf(i)));
        	JSONObject jsonUti2 = new JSONObject(jsonTheme.getString(String.valueOf(i)));
        	
        	while(!(themes.isEmpty())) {
        	if(jsonUti1.getInt("id_proposition")== Integer.parseInt(themes.get(0))) {
        		if(jsonUti2.getInt("Id_Theme")==jsonUti1.getInt("Id_Theme")) {
        		if (nb == 0) {
        			Theme1 = jsonUti2;
        			

        		themes.remove(0);
        		nb++;
        		}
        		else {
        			Theme2 = jsonUti2;
        			T2Existe = true;
        		}
        		
        	}}
        	}
        }

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
		lblInfo_2.setBounds(285, 346, 290, 33);
		add(lblInfo_2);
		
		JLabel lblModifierLeBudget = new JLabel("Modifier le budget: ");
		lblModifierLeBudget.setBounds(20, 181, 117, 14);
		add(lblModifierLeBudget);
		
		JLabel lblTheme = new JLabel("Themes :");
		lblTheme.setBounds(21, 216, 67, 13);
		add(lblTheme);
		
		JLabel lblBudgetTheme = new JLabel("Modifier Budget Thème");
		lblBudgetTheme.setBounds(20, 273, 179, 13);
		add(lblBudgetTheme);
		
		String budget1= Theme1.getString("Limite_Budget_Thematique");
		JLabel lblThemeBud1 = new JLabel(budget1);
		lblThemeBud1.setBounds(209, 240, 126, 13);
		add(lblThemeBud1);

		
		JTextArea NvBudgetTheme = new JTextArea();
		NvBudgetTheme.setBounds(209, 267, 89, 22);
		add(NvBudgetTheme);
		
		String titre1 = Theme1.getString("Nom_Theme");
		JLabel lblThemeDef1 = new JLabel(titre1);
		lblThemeDef1.setBounds(209, 216, 103, 13);
		add(lblThemeDef1);
		JButton btnModifBudget1 = new JButton("Modifier");
		btnModifBudget1.setBounds(213, 300, 85, 21);
		add(btnModifBudget1);

		if(T2Existe) {
		String titre2 = Theme2.getString("Nom_Theme");
		JLabel lblThemeDef2 = new JLabel(titre2);
		lblThemeDef2.setBounds(445, 216, 126, 13);
		add(lblThemeDef2);
	
		String budget2 = Theme2.getString("Limite_Budget_Thematique");
		JLabel lblThemeBud2 = new JLabel(budget2);
		lblThemeBud2.setBounds(445, 240, 126, 13);
		add(lblThemeBud2);

		
		JTextArea textArea_1 = new JTextArea();
		textArea_1.setBounds(445, 267, 89, 22);
		add(textArea_1);

		JButton btnNewButton_1 = new JButton("Modifier");
		btnNewButton_1.setBounds(445, 300, 85, 21);
		add(btnNewButton_1);
		}
		int idVote =0;
		JSONObject jsonVote= new JSONObject();
		jsonVote = connect.con("Vote");

        for(int i = 0 ; i<jsonVote.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonVote.getString(String.valueOf(i)));

        	if(jsonUti1.getInt("id_proposition")==idProp) {
        		idVote = jsonUti1.getInt("Id_Vote");
        	}

        }
		JLabel lblC;

		lblC= new JLabel("nomChoix");
		lblC.setBounds(256, 374, 221, 33);
		//add(lblC);
		
		JLabel lblBudgetActuel = new JLabel("Budget actuel :");
		lblBudgetActuel.setBounds(20, 240, 132, 13);
		add(lblBudgetActuel);


		JSONObject jsonChoix = connect.con("Choix");
		int variable = 384;
		JLabel lblChoix;
        for(int i = 0 ; i<jsonChoix.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonChoix.getString(String.valueOf(i)));
        	

        	if(jsonUti1.getInt("Id_Vote")==idVote) {
        		String nomChoix = jsonUti1.getString("Nom_Choix");
        		
        		lblChoix= new JLabel(nomChoix);
        		lblChoix.setBounds(256, variable, 221, 33);
        		add(lblChoix);
        		
        		variable = variable+20;

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
