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
					
					System.out.print("le content");
					System.out.print(content);
					
					String info = content.substring(1, content.length()-1);
					  
					  JSONObject json;
					  String id ;
					  
					  while(info.length() > 3) {
						  json = new JSONObject(info);//transoformer le string en json
						  id = json.getString("Id_Utilisateur");
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
			    
			  JSONObject jojo = con("utilisateur");
			  
			  
			  System.out.println("ce qui est sencé fonctionner");
			  
			  System.out.println(jojo);
			  
				System.out.println("partie test");
				
			  String blabla = "[{\"Id_Utilisateur\":1,\"Nom_Utilisateur\":\"Doe\",\"Prenom_Utilisateur\":\"John\",\"Adr_Utilisateur\":\"123 Rue Principale\",\"Cp_Utilisateur\":75001,\"Mail_Utilisateur\":\"john.doe@example.com\",\"Login_Utilisateur\":\"johndoe\",\"Pdp_Utilisateur\":\"dncjsknjkvdsk\"},{\"Id_Utilisateur\":2,\"Nom_Utilisateur\":\"Smith\",\"Prenom_Utilisateur\":\"Jane\",\"Adr_Utilisateur\":\"456 Avenue des Champs\",\"Cp_Utilisateur\":75002,\"Mail_Utilisateur\":\"jane.smith@example.com\",\"Login_Utilisateur\":\"janesmith\",\"Pdp_Utilisateur\":\"njdksvjknd\"},{\"Id_Utilisateur\":3,\"Nom_Utilisateur\":\"Brown\",\"Prenom_Utilisateur\":\"Alice\",\"Adr_Utilisateur\":\"789 Boulevard Haussmann\",\"Cp_Utilisateur\":75008,\"Mail_Utilisateur\":\"alice.brown@example.com\",\"Login_Utilisateur\":\"alicebrown\",\"Pdp_Utilisateur\":\"nvjksjkdjkfd\"},{\"Id_Utilisateur\":4,\"Nom_Utilisateur\":\"Taylor\",\"Prenom_Utilisateur\":\"Bob\",\"Adr_Utilisateur\":\"321 Rue Lafayette\",\"Cp_Utilisateur\":75010,\"Mail_Utilisateur\":\"bob.taylor@example.com\",\"Login_Utilisateur\":\"bobtaylor\",\"Pdp_Utilisateur\":\"ikoezkfoie\"},{\"Id_Utilisateur\":5,\"Nom_Utilisateur\":\"Johnson\",\"Prenom_Utilisateur\":\"Emily\",\"Adr_Utilisateur\":\"654 Avenue Montaigne\",\"Cp_Utilisateur\":75016,\"Mail_Utilisateur\":\"emily.johnson@example.com\",\"Login_Utilisateur\":\"emilyjohnson\",\"Pdp_Utilisateur\":\"jnkckdsfveji\"}]";
			  String bla = "java8";
			  
			  
			  
			  String info = blabla.substring(1, blabla.length()-1);
			  
			  JSONObject json;
			  String id ;
			  JSONObject jsonFinal = new JSONObject();
			  while(info.length() > 3) {
				  json = new JSONObject(info);//transoformer le string en json
				  id = json.getString("Id_Utilisateur");
				  jsonFinal.put(id, json);
				  if(info.length()-json.toString(0).length()-(json.length()*2)>0) {
				  info = info.substring(json.toString(0).length()-(json.length()*2), info.length());
				  }
				  else {
					  info = info.substring(json.toString(0).length()-(json.length()*2)-1, info.length());
				  }
			  }
			  
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


