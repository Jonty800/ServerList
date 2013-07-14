static void Send800CraftNetBeat()
        {
            if ( Server."http://YourServerUrl";
            // create a request
            try {
                HttpWebRequest request = ( HttpWebRequest )WebRequest.Create( uri );
                request.Method = "POST";

                // turn request string into a byte stream
                byte[] postBytes = Encoding.ASCII.GetBytes( string.Format( "ServerName={0}&Url={1}&Players={2}&MaxPlayers={3}&Uptime={4}",
                                 Uri.EscapeDataString( ConfigKey.ServerName.GetString() ),
                                 Server.Uri,
                                 Server.Players.Length,
                                 ConfigKey.MaxPlayers.GetInt(),
                                 DateTime.UtcNow.Subtract( Server.StartTime ).TotalMinutes ) );

                request.ContentType = "application/x-www-form-urlencoded";
                request.CachePolicy = new System.Net.Cache.RequestCachePolicy( System.Net.Cache.RequestCacheLevel.NoCacheNoStore );
                request.ContentLength = postBytes.Length;
                request.Timeout = 5000;
                Stream requestStream = request.GetRequestStream();

                // send it
                requestStream.Write( postBytes, 0, postBytes.Length );
                requestStream.Flush();
                requestStream.Close();
            } catch ( Exception e ) {
                //do nothing, server is probably down and host doesnt care
            }
        }