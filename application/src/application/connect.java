package application;

import java.sql.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.net.* ;
import java.util.Iterator;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import org.json.*;

public class connect {
	public static void start() { 
		  try {
		  URL url = new URL("https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET");

		// Open a connection(?) on the URL(??) and cast the response(???)
		HttpURLConnection connection = (HttpURLConnection) url.openConnection();
		
		// Now it's "open", we can set the request method, headers etc.
		connection.setRequestProperty("accept", "application/json");

		// This line makes the request
		InputStream responseStream = connection.getInputStream();

		// Finally we have the response
		System.out.println(responseStream);
		
		  }catch(Exception e) {
			  System.out.println("dcks,kj");
				System.out.println(e);
				}
		   }
	
		  public static void con() {
			  URL url;
			try {
				url = new URL("https://projets.iut-orsay.fr/saes3-aviau/TestProket/Web/controller/api.php/utilisateur/?method=GET");
			
			  HttpURLConnection con = (HttpURLConnection) url.openConnection();
			  con.setRequestMethod("GET");
			  
		 } catch (MalformedURLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
	}
		  
		  public static void main(String[] args) {
			    
				System.out.println("Ccoucou");
				start();

				  }
			
}
