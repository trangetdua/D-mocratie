package application;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.*;
import javax.swing.event.ListSelectionEvent;
import javax.swing.event.ListSelectionListener;

import org.json.JSONException;
import org.json.JSONObject;
 
public class JListExemple extends JFrame implements ListSelectionListener
{
    private JList<String> langages;
  
    public JListExemple(int idGroupe) throws JSONException 
    {
    	JSONObject jsonPropo = connect.con("Proposition","id_proposition");
        //créer le modèle et ajouter des éléments
    	
		  //System.out.println(jsonUti1.getString("Mail_Utilisateur"));
        DefaultListModel<String> model = new DefaultListModel<>();
        for(int i = 1 ; i<=jsonPropo.length(); i++) {
        	JSONObject jsonUti1 = new JSONObject(jsonPropo.getString(String.valueOf(i)));
        	int groupe = Integer.parseInt(jsonUti1.getString("Id_Groupe"));
        	
        	if(groupe == idGroupe) {
        		System.out.println("jshxkjd");
        		model.addElement(jsonUti1.getString("Titre_Proposition"));
        	}
        	
        }
        
       
        
 
        //créer la liste des langages
        langages = new JList<>(model);
        add(langages);
         
        this.setTitle("Exemple de JList");  
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);     
        this.setSize(200,200);
        this.setLocationRelativeTo(null);
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
					new JListExemple(1);
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
            }
        });
    }

	@Override
	public void valueChanged(ListSelectionEvent e) {
		// TODO Auto-generated method stub
		
	}       
}
