package application;

import java.sql.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.io.*;
import java.net.* ;
import java.util.*;
import java.util.Map;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import org.json.*;

public class connect {
	public static void start() { 
		Connection connection;
		Statement statement ;
		 
		ResultSet resultSet ;
		ResultSetMetaData metaData ;
		int numberOfColumns = 0;
		
		try
		 
		{
		 
		Class.forName("com.mysql.jdbc.Driver");
		
		connection = DriverManager.getConnection("jdbc:mysql://projets.iut-orsay.fr/phpmyadmin/:3306/saes3-aviau" ,"saes3-aviau","ymPVbOHi9IjBplOm"); 
		 System.out.println("Con");
		statement = connection.createStatement();
		 
		System.out.println("Connection Established");
		 
		 
		}catch(ClassNotFoundException | SQLException e){
		    System.err.println(e);
		}
		   }
			public static void update(String table, String colloneModif, String colloneWhere, int condition, float valeur) {
				  URL url;
				  JSONObject jsonFinal = new JSONObject();
				try {
					url = new URL("https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/" + table + "/"+ colloneWhere + "/"+ condition+"/"+colloneModif+ "/"+valeur +"/?method=PUT");
					  HttpURLConnection con = (HttpURLConnection) url.openConnection();
					  con.setRequestMethod("PUT");
					  Map<String, String> parameters = new HashMap<>();
					  parameters.put("param1", "val");
					  
					  
					  con.setDoOutput(true);
					  DataOutputStream out = new DataOutputStream(con.getOutputStream());
					  out.writeBytes(ParameterStringBuilder.getParamsString(parameters));
					  
					  out.flush();
					  out.close();
					  
					  int status = con.getResponseCode();


				} catch (MalformedURLException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}


			}
		  public static JSONObject con(String donnees) throws JSONException {
			  URL url;
			  JSONObject jsonFinal = new JSONObject();
			try {
				url = new URL("https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/" + donnees + "/?method=GET");
			
			  HttpURLConnection con = (HttpURLConnection) url.openConnection();
			  con.setRequestMethod("GET");
			  
			  Map<String, String> parameters = new HashMap<>();
			  parameters.put("param1", "val");
			  
			  
			  con.setDoOutput(true);
			  DataOutputStream out = new DataOutputStream(con.getOutputStream());
			  out.writeBytes(ParameterStringBuilder.getParamsString(parameters));
			  
			  out.flush();
			  out.close();
			  
			  int status = con.getResponseCode();
			  BufferedReader in = new BufferedReader(
					  new InputStreamReader(con.getInputStream()));
					String inputLine;
					StringBuffer content = new StringBuffer();
					
					
					while ((inputLine = in.readLine()) != null) {
					    content.append(inputLine);
					}
					in.close();
					
					
					String info = content.substring(1, content.length()-1);
					  
					  JSONObject json;
					  String id;
					  int i = 0;
					  while(info.length() > 3) {
						  json = new JSONObject(info);//transoformer le string en json
						  
						  id = String.valueOf(i);
						  i+=1;
						  jsonFinal.put(id, json);
						  
						  if(info.length()-json.toString(0).length()-(json.length()*2)>0) {
						  info = info.substring(json.toString(0).length()-(json.length()*2), info.length());
						  }
						  else {
							  info = info.substring(json.toString(0).length()-(json.length()*2)-1, info.length());
						  }
					  }
					
					con.disconnect();
					
			  
			  
		 } catch (MalformedURLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			return jsonFinal;
	}
		  
		  public static void main(String[] args) throws JSONException {
			    
			  JSONObject jojo = con("Proposition");
			  
			  
			  System.out.println("ce qui est sencé fonctionner");
			  
			  System.out.println(jojo);
			  
				System.out.println("partie test");
				
			  //String blabla = "[{\"Id_Utilisateur\":1,\"Nom_Utilisateur\":\"Doe\",\"Prenom_Utilisateur\":\"John\",\"Adr_Utilisateur\":\"123 Rue Principale\",\"Cp_Utilisateur\":75001,\"Mail_Utilisateur\":\"john.doe@example.com\",\"Login_Utilisateur\":\"johndoe\",\"Pdp_Utilisateur\":\"dncjsknjkvdsk\"},{\"Id_Utilisateur\":2,\"Nom_Utilisateur\":\"Smith\",\"Prenom_Utilisateur\":\"Jane\",\"Adr_Utilisateur\":\"456 Avenue des Champs\",\"Cp_Utilisateur\":75002,\"Mail_Utilisateur\":\"jane.smith@example.com\",\"Login_Utilisateur\":\"janesmith\",\"Pdp_Utilisateur\":\"njdksvjknd\"},{\"Id_Utilisateur\":3,\"Nom_Utilisateur\":\"Brown\",\"Prenom_Utilisateur\":\"Alice\",\"Adr_Utilisateur\":\"789 Boulevard Haussmann\",\"Cp_Utilisateur\":75008,\"Mail_Utilisateur\":\"alice.brown@example.com\",\"Login_Utilisateur\":\"alicebrown\",\"Pdp_Utilisateur\":\"nvjksjkdjkfd\"},{\"Id_Utilisateur\":4,\"Nom_Utilisateur\":\"Taylor\",\"Prenom_Utilisateur\":\"Bob\",\"Adr_Utilisateur\":\"321 Rue Lafayette\",\"Cp_Utilisateur\":75010,\"Mail_Utilisateur\":\"bob.taylor@example.com\",\"Login_Utilisateur\":\"bobtaylor\",\"Pdp_Utilisateur\":\"ikoezkfoie\"},{\"Id_Utilisateur\":5,\"Nom_Utilisateur\":\"Johnson\",\"Prenom_Utilisateur\":\"Emily\",\"Adr_Utilisateur\":\"654 Avenue Montaigne\",\"Cp_Utilisateur\":75016,\"Mail_Utilisateur\":\"emily.johnson@example.com\",\"Login_Utilisateur\":\"emilyjohnson\",\"Pdp_Utilisateur\":\"jnkckdsfveji\"}]";
			  //String blabla = "[{\"Id_Groupe\":1,\"Nom_Groupe\":\"Club Environnement\",\"Image_Groupe\":\"environnement.png\",\"Couleur_Groupe\":\"3a7ca5\",\"Limite_Budget_Global\":\"10000\",\"Id_Utilisateur\":1},{\"Id_Groupe\":2,\"Nom_Groupe\":\"Association Sportive\",\"Image_Groupe\":\"sport.png\",\"Couleur_Groupe\":\"0a9396\",\"Limite_Budget_Global\":\"20000\",\"Id_Utilisateur\":2},{\"Id_Groupe\":3,\"Nom_Groupe\":\"Club Technologie\",\"Image_Groupe\":\"tech.png\",\"Couleur_Groupe\":\"780404\",\"Limite_Budget_Global\":\"15000\",\"Id_Utilisateur\":3},{\"Id_Groupe\":4,\"Nom_Groupe\":\"Groupe Sante\",\"Image_Groupe\":\"sante.png\",\"Couleur_Groupe\":\"620581\",\"Limite_Budget_Global\":\"12000\",\"Id_Utilisateur\":4},{\"Id_Groupe\":5,\"Nom_Groupe\":\"Collectif Education\",\"Image_Groupe\":\"education.png\",\"Couleur_Groupe\":\"0a9396\",\"Limite_Budget_Global\":\"18000\",\"Id_Utilisateur\":5},{\"Id_Groupe\":6,\"Nom_Groupe\":\"Club Voyage\",\"Image_Groupe\":\"voyage.png\",\"Couleur_Groupe\":\"3a7ca5\",\"Limite_Budget_Global\":\"10000\",\"Id_Utilisateur\":3},{\"Id_Groupe\":7,\"Nom_Groupe\":\"Club Gastronomie\",\"Image_Groupe\":\"gastronomie.png\",\"Couleur_Groupe\":\"0a9396\",\"Limite_Budget_Global\":\"12000\",\"Id_Utilisateur\":3},{\"Id_Groupe\":8,\"Nom_Groupe\":\"Club Science\",\"Image_Groupe\":\"science.png\",\"Couleur_Groupe\":\"3a7ca5\",\"Limite_Budget_Global\":\"15000\",\"Id_Utilisateur\":5},{\"Id_Groupe\":9,\"Nom_Groupe\":\"Groupe IUT\",\"Image_Groupe\":\"sience.png\",\"Couleur_Groupe\":\"3a7ca5\",\"Limite_Budget_Global\":\"150000\",\"Id_Utilisateur\":5},{\"Id_Groupe\":26,\"Nom_Groupe\":\"Nouveau_groupe\",\"Image_Groupe\":null,\"Couleur_Groupe\":\"3a7ca5\",\"Limite_Budget_Global\":null,\"Id_Utilisateur\":1}]";
				String blabla = "[{\"id_proposition\":1,\"Titre_Proposition\":\"Installer des poubelles de tri\",\"Description_Proposition\":\"Faciliter le recyclage avec des poubelles de tri\",\"Duree_Discussion_Proposition\":30,\"evaluation_budgetaire\":\"1500\",\"Signaler\":1,\"Id_Utilisateur\":1,\"Id_Groupe\":1},{\"id_proposition\":2,\"Titre_Proposition\":\"Creer une equipe de football\",\"Description_Proposition\":\"Encourager les jeunes avec une equipe locale\",\"Duree_Discussion_Proposition\":45,\"evaluation_budgetaire\":\"5000\",\"Signaler\":0,\"Id_Utilisateur\":2,\"Id_Groupe\":2},{\"id_proposition\":3,\"Titre_Proposition\":\"Organiser un hackathon\",\"Description_Proposition\":\"Stimuler et reunir les gens autour de la technologie\",\"Duree_Discussion_Proposition\":60,\"evaluation_budgetaire\":\"3000\",\"Signaler\":0,\"Id_Utilisateur\":3,\"Id_Groupe\":3},{\"id_proposition\":4,\"Titre_Proposition\":\"Ateliers sante\",\"Description_Proposition\":\"Prevention sur la sante et le bien-etre\",\"Duree_Discussion_Proposition\":40,\"evaluation_budgetaire\":\"2000\",\"Signaler\":0,\"Id_Utilisateur\":4,\"Id_Groupe\":4},{\"id_proposition\":5,\"Titre_Proposition\":\"Campagne alphabetisation\",\"Description_Proposition\":\"Investir pour une meilleur education dans les zones rurales \",\"Duree_Discussion_Proposition\":50,\"evaluation_budgetaire\":\"2500\",\"Signaler\":0,\"Id_Utilisateur\":5,\"Id_Groupe\":5},{\"id_proposition\":6,\"Titre_Proposition\":\"Planter des arbres\",\"Description_Proposition\":\"Reboisement des zones degradees\",\"Duree_Discussion_Proposition\":20,\"evaluation_budgetaire\":\"3000\",\"Signaler\":0,\"Id_Utilisateur\":3,\"Id_Groupe\":6},{\"id_proposition\":7,\"Titre_Proposition\":\"Exposition artistique\",\"Description_Proposition\":\"Promouvoir les jeunes artistes locaux\",\"Duree_Discussion_Proposition\":25,\"evaluation_budgetaire\":\"5000\",\"Signaler\":0,\"Id_Utilisateur\":4,\"Id_Groupe\":7},{\"id_proposition\":8,\"Titre_Proposition\":\"Laboratoires educatifs\",\"Description_Proposition\":\"Creer des laboratoires mobiles pour les ecoles\",\"Duree_Discussion_Proposition\":30,\"evaluation_budgetaire\":\"7000\",\"Signaler\":0,\"Id_Utilisateur\":5,\"Id_Groupe\":8}]";
				System.out.println(blabla);
			  
			  String info = blabla.substring(1, blabla.length()-1);
			  
			  JSONObject json;
			  String id ;
			  JSONObject jsonFinal = new JSONObject();
			  while(info.length() > 3) {
				  json = new JSONObject(info);//transoformer le string en json
				  id = json.getString("Id_Groupe");
				  System.out.println(json);
				  jsonFinal.put(id, json);
				  if(info.length()-json.toString(0).length()-(json.length()*2)>0) {
				  info = info.substring(json.toString(0).length()-(json.length()*2), info.length());
				  }
				  else {
					  info = info.substring(json.toString(0).length()-(json.length()*2)-1, info.length());
				  }
				  System.out.println(info);
			  }
			  
			  System.out.println(jsonFinal.getString("1"));
			  
			  //recuperer une donnée precise 
			  //JSONObject jsonUti1 = new JSONObject(jsonFinal.getString("1"));
			  //System.out.println(jsonUti1.getString("Mail_Utilisateur"));
			  
			  System.out.println(jsonFinal);
			  /*
			  System.out.println(blo);
			  
			  JSONObject jlo = new JSONObject(blo);
			  System.out.println(jlo);
	
			  String blo2 = blo.substring(0, jlo.toString(0).length()-(jlo.length()*2));//prendla suite du string 
			  
			  
			  System.out.println(blo2);
			  
			  
			  JSONObject jlo2 = new JSONObject(blo2);
			  
			  
			  System.out.println(jlo2);
			  
			  Map<String, String> map = new HashMap<>();
			  map.put("name", "jon doe");
			  map.put("age", "22");
			  map.put("city", "chicago");
			  JSONObject jo = new JSONObject(map);
			  String city = jo.getString("city");
			  System.out.println(jlo.toString(0));
			  
			  //System.out.println(blabla["Id_Utilisateur"]);
				*/

				  }
			
}


