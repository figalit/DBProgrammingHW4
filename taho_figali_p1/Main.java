import java.sql.*;
import java.util.Properties;

public class Main {
	// The JDBC Connector Class.
	private static final String dbClassName = "com.mysql.jdbc.Driver";
	private static final String connection_db =
			"jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/figali_taho";
	private static final String user = "figali.taho";
	private static final String pass = "fob6r5.o";
	private static final String addit = "&useUnicode=true&characterEncoding=UTF-8";
	public static void main(String args[]) throws ClassNotFoundException,SQLException
	{
	    Connection conn = null;
	    Statement stmt = null;
	    try {
	    	// Connecting to the remote database on dijkstra.
		    Class.forName(dbClassName);
	        conn = DriverManager.getConnection(connection_db + "?user=" + user + "&password=" + pass + addit);
	        print("Connected to db.");
	        
	        // Statements for creating the tables. 
	        String[] sqlStatements = new String[3];
	        sqlStatements[0] = "CREATE TABLE student ( sid CHAR(12), sname VARCHAR(50), bdate DATE, " +
	        		"address VARCHAR(50), scity VARCHAR(20), year CHAR(20), gpa FLOAT, " +
	        		"nationality VARCHAR(20),PRIMARY KEY (sid) );";
	        sqlStatements[1] = "CREATE TABLE company ( cid CHAR(8), cname VARCHAR(20), quota INT, PRIMARY KEY (cid) );";
	        sqlStatements[2] = "CREATE TABLE apply ( sid CHAR(12), cid CHAR(8),FOREIGN KEY (sid) REFERENCES student(sid), " +
	        		" FOREIGN KEY (cid) REFERENCES company(cid)) ENGINE=INNODB;";
	        
	        // Explicit check if any of the tables does exist in db already.
	        DatabaseMetaData meta = conn.getMetaData();
	        ResultSet result = meta.getTables(null, null, "%", null);
	        stmt = conn.createStatement();
	        String[] tablenames = {"student", "company", "apply"};
	        while( result.next()){
	        	String cur = result.getString("TABLE_NAME");
	        	if(cur.equals(tablenames[0])){
	        		stmt.execute("DROP TABLE " + tablenames[0]);
	        		print("Dropping " + tablenames[0]);
	        	}
	        	else if (cur.equals(tablenames[1])){
	        		stmt.execute("DROP TABLE " + tablenames[1]);
	        		print("Dropping " + tablenames[1]);
	        	}
	        	else if(cur.equals(tablenames[2])){
	        		stmt.execute("DROP TABLE " + tablenames[2]);
	        		print("Dropping " + tablenames[2]);
	        	}
	        }
	        
	        
	        // Execute queries.
	        for (int i = 0; i < sqlStatements.length; i++){
	        	stmt.execute(sqlStatements[i]);
	        	print("Adding table " + tablenames[i]);
	        }
	        
	        /////////////////////
	        // student table fill
	        String helperStudentsInsert = "INSERT INTO student " +
	        								"( sid, sname, bdate, address, scity, year, gpa, nationality )" +
	        								"VALUES ";
	        String[] allStudents = {
	        		"( '21000001', 'Ayse', '1995-05-10', 'Tunali', 'Ankara', 'senior', 2.75, 'TC' )", 
	        		"( '21000002', 'Ali', '1997-09-12', 'Nisantasi', 'Istanbul', 'junior', 3.44, 'TC' )",
	        		"( '21000003', 'Veli', '1998-10-25', 'Nisantasi', 'Istanbul', 'freshman', 2.36, 'TC' )",
	        		"( '21000004', 'John', '1999-01-15', 'Windy', 'Chicago', 'freshman', 2.55, 'US' )"
	        		};
	        for( int i = 0; i < allStudents.length; i++){
	        	stmt.execute(helperStudentsInsert + allStudents[i] + ";");
	        }
	        print("Inserted student data");
	        
	        /////////////////////
	        // company table fill
	        String helperCompanyInsert = "INSERT INTO company" +
	        		"( cid, cname, quota )" +
	        		"VALUES ";
	        String[] allCompanies = {
	        		"( 'C101', 'tubitak', 2 )", 
	        		"( 'C102', 'aselsan', 5 )",
	        		"( 'C103', 'havelsan', 3 )",
	        		"( 'C104', 'microsoft', 5 )",
	        		"( 'C105', 'merkez bankasi', 3 )",
	        		"( 'C106', 'tai', 4 )",
	        		"( 'C107', 'milsoft', 2 )"
	        		};
	        for( int i = 0; i < allCompanies.length; i++){
	        	stmt.execute(helperCompanyInsert + allCompanies[i] + ";");
	        }
	        print("Inserted company data");
	        
	        ///////////////////
	        // apply table fill
	        String helperApplyInsert = "INSERT INTO apply" +
	        		"( sid, cid )" +
	        		"VALUES ";
	        String[] allApply = {
	        		"( '21000001', 'C101' )", 
	        		"( '21000001', 'C102')",
	        		"( '21000001', 'C103')",
	        		"( '21000002', 'C101')",
	        		"( '21000002', 'C105')",
	        		"( '21000003', 'C104')",
	        		"( '21000003', 'C105')", 
	        		"( '21000004', 'C107')"
	        		};
	        for( int i = 0; i < allApply.length; i++){
	        	stmt.execute(helperApplyInsert + allApply[i] + ";");
	        }
	        print("Inserted apply data");
	        
	        // Display tables information.
	        for (int i = 0; i < tablenames.length; i++){
	        	ResultSet tableRes = stmt.executeQuery("SELECT * FROM " + tablenames[i]);
	        	print("");
	        	print("//////////////////");
	        	print( tablenames[i]);
	        	print("//////////////////");
	        	while(tableRes.next()){
	        		String temp = "";
	        		for (int j = 1; j <= tableRes.getMetaData().getColumnCount(); j++){
	        			temp += tableRes.getString(j) + "\t   ";
	        		}
	        		print(temp);
	        	}
	        }
	        
	    } catch (SQLException ex) {
	        // handle any errors
	        System.out.println("SQLException: " + ex.getMessage());
	        System.out.println("SQLState: " + ex.getSQLState());
	        System.out.println("VendorError: " + ex.getErrorCode());
	    }
	    conn.close();
	}

	// Used for printing easily.
	static void print(String ar){
		System.out.println(ar);
	}
}
