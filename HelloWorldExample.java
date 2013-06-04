import java.io.*;
import java.net.*;
import java.text.*;
import java.util.*;
import javax.servlet.*;
import javax.servlet.http.*;
import org.jdom.*;
import org.jdom.input.SAXBuilder;



public class HelloWorldExample extends HttpServlet {


    public void doGet(HttpServletRequest request,
                      HttpServletResponse response)
        throws IOException, ServletException, MalformedURLException
    {
        
        response.setContentType("text/html; charset=UTF-8");  
        
        String title = request.getParameter("title");
        String type = request.getParameter("type");
        PrintWriter out = response.getWriter();
		
        StringBuffer buffer=new StringBuffer();
        for(int i=0;i<title.length();i++)
        {
            if(title.charAt(i)==' ')
            {
                buffer.append("%20");
            }
            else
            {
                buffer.append(title.charAt(i));
            }
        }
        title=buffer.toString();
        
        try
        {
            URLEncoder.encode(title, "UTF-8");
            URL url=new URL("http://cs-server.usc.edu:38512/get_discography2.php?title="+title+"&type="+type);
            
            URLConnection connect=url.openConnection();
            connect.setAllowUserInteraction(false);

            InputStream xmlStream=url.openStream();
            
            SAXBuilder parser = new SAXBuilder();
            Document document=(Document)parser.build(xmlStream);
            Element root=document.getRootElement();
            String string=new String();
            
            if(type.equals("artists"))
            {
                List list=root.getChildren("result");
        		string="{\"results\":{\"result\":[";
        		for(int i=0;i<list.size();i++)
        		{
            	Element temp=(Element)list.get(i);
            	string+="{\"cover\":\""+temp.getAttributeValue("cover")+"\",";
            	string+="\"name\":\""+temp.getAttributeValue("name")+"\",";
            	string+="\"genre\":\""+temp.getAttributeValue("genre") +"\",";
            	string+="\"year\":\""+temp.getAttributeValue("year")+"\",";
            	string+="\"details\":\""+temp.getAttributeValue("details")+"\"}";
            		if(i!=list.size()-1)
            		{
                		string+=",";
            		}
        		}
        		string+="]}}";
            }
            else if(type.equals("albums"))
            {
        		List list=root.getChildren("result");
        		string="{\"results\":{\"result\":[";
		        for(int i=0;i<list.size();i++)
        		{
            		Element temp=(Element)list.get(i);
		            string+="{\"cover\":\""+temp.getAttributeValue("cover")+"\",";
        		    string+="\"title\":\""+temp.getAttributeValue("title")+"\",";
		            string+="\"artist\":\""+temp.getAttributeValue("artist")+"\",";
         		    string+="\"genre\":\""+temp.getAttributeValue("genre") +"\",";
           			string+="\"year\":\""+temp.getAttributeValue("year")+"\",";
            		string+="\"details\":\""+temp.getAttributeValue("details")+"\"}";
            		if(i!=list.size()-1)
            		{
                		string+=",";
            		}
            	}
        		string+="]}}";
            }
            else if(type.equals("songs"))
            {
                List list=root.getChildren("result");
        		string="{\"results\":{\"result\":[";
        		for(int i=0;i<list.size();i++)
        		{
            		Element temp=(Element)list.get(i);
            		string+="{\"sample\":\""+temp.getAttributeValue("sample")+"\",";
            		string+="\"title\":\""+temp.getAttributeValue("title")+"\",";
            		string+="\"performer\":\""+temp.getAttributeValue("performer")+"\",";
            		string+="\"composers\":\""+temp.getAttributeValue("composers")+"\",";
            		string+="\"details\":\""+temp.getAttributeValue("details")+"\"}";
            		if(i!=list.size()-1)
            		{
               			string+=",";
            		}
        		}
       			 string+="]}}";
            }
            out.println(string);
        }
        catch(MalformedURLException e)
        {
            out.println("MalformedURLException");
        }
        catch(JDOMException e)
        {
        	out.println("JDOMException");
        }	  
        catch(IOException e)
        {
        	out.println("IOException");
        }  
        catch(Exception e)
        {
        	out.println("OTHERException");
        }
    }
}



