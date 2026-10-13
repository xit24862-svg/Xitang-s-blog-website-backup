# Z-Blog routing fix

This site has a static welcome page at `/index.html` and the blog app at `/index.php`.

If a post URL such as `/post/1.html` falls back to `/index.html`, the browser shows
`WELCOME TO XiTang's TIANXIA` instead of the post. That happens when the server routes
missing paths to `index.html` instead of `index.php`.

Changes made here:

- The Zit theme now generates article links as `/index.php?id=ID`, so post clicks do not
  depend on rewrite support.
- `.htaccess` keeps `/` on the welcome page and routes unknown Apache paths to
  `/index.php`.
- `nginx-zblog-rewrite.conf` contains the equivalent Nginx rule. On BaoTa/Nginx, paste
  that snippet into the site's Nginx config or rewrite config, replacing any fallback to
  `/index.html`.

After upload, clear Z-Blog cache/modules in the admin panel if old post links remain.
