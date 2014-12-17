<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
  xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url> 
        <loc><?php echo Router::url('/',true); ?></loc>
        <image:image>
            <image:loc><?php echo Router::url('/',true); ?>img/toplogo.png</image:loc> 
        </image:image>
        <changefreq>always</changefreq> 
        <priority>1.0</priority> 
    </url> 

    <url> 
       <loc><?php echo Router::url('/',true); ?>about</loc>
        <image:image>
            <image:loc><?php echo Router::url('/',true); ?>img/toplogo.png</image:loc> 
        </image:image>
        <changefreq>never</changefreq> 
        <priority>0.5</priority> 
    </url> 

<url> 
       <loc><?php echo Router::url('/',true); ?>about/sites</loc>
        <image:image>
            <image:loc><?php echo Router::url('/',true); ?>img/toplogo.png</image:loc> 
        </image:image>
        <changefreq>always</changefreq> 
        <priority>0.6</priority> 
    </url> 
    
</urlset>