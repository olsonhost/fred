# FRED
### (A portmanteau of Php and @)

# I HAVE CHANGED THE NAME OF THIS PACKAGE TO "FRED"
### This tool is going to be platform agnostic so we won't be parsing Php in it
#### Hence the old name "Phat" or "Ph@", while terrible, don't really apply to this thing

##### And since it has the syntax of ye old "Framework Fred" of Yore (see what I did there?) I think that "Fred" is a cool name for this.

###### Also my frog is named Fred

* And I have a brother named Fred
  * Somewhere
    * In Texas I think
      * He has a wife, you know



@blackrush()

returns
```

 ▄▄▄▄    ██▓    ▄▄▄       ▄████▄   ██ ▄█▀ ██▀███   █    ██   ██████  ██░ ██
▓█████▄ ▓██▒   ▒████▄    ▒██▀ ▀█   ██▄█▒ ▓██ ▒ ██▒ ██  ▓██▒▒██    ▒ ▓██░ ██▒
▒██▒ ▄██▒██░   ▒██  ▀█▄  ▒▓█    ▄ ▓███▄░ ▓██ ░▄█ ▒▓██  ▒██░░ ▓██▄   ▒██▀▀██░
▒██░█▀  ▒██░   ░██▄▄▄▄██ ▒▓▓▄ ▄██▒▓██ █▄ ▒██▀▀█▄  ▓▓█  ░██░  ▒   ██▒░▓█ ░██
░▓█  ▀█▓░██████▒▓█   ▓██▒▒ ▓███▀ ░▒██▒ █▄░██▓ ▒██▒▒▒█████▓ ▒██████▒▒░▓█▒░██▓
░▒▓███▀▒░ ▒░▓  ░▒▒   ▓▒█░░ ░▒ ▒  ░▒ ▒▒ ▓▒░ ▒▓ ░▒▓░░▒▓▒ ▒ ▒ ▒ ▒▓▒ ▒ ░ ▒ ░░▒░▒
▒░▒   ░ ░ ░ ▒  ░ ▒   ▒▒ ░  ░  ▒   ░ ░▒ ▒░  ░▒ ░ ▒░░░▒░ ░ ░ ░ ░▒  ░ ░ ▒ ░▒░ ░
 ░    ░   ░ ░    ░   ▒   ░        ░ ░░ ░   ░░   ░  ░░░ ░ ░ ░  ░  ░   ░  ░░ ░
 ░          ░  ░     ░  ░░ ░      ░  ░      ░        ░           ░   ░  ░  ░
      ░                  ░
```

You can do other stuff too.  Like markdown and several "@" functions designed to work with Yore such as

@asset('dir/file.ext') - Returns a full path to an asset (usually an image) in the current site's theme

@body() - returns the page body as defined in the page JSON (you can use this instead of or in addition to HTML in your view file)

@data('var') - returns any top level element of the current page's JSON object. For examlle @data('body') would be the same as @body()

@edit('/dir/dir/file.txt') - returns the HTML for an edit button to allow the user to edit a server file (off of the web root) in the browser.  For example, @edit(#view) will return HTML for a button to edit the current view file source code

#view - returns the path and file name (relative to web root) of the current view

# SQML

# Doors

# Short Codes

# Extending with Modules