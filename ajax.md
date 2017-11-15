**getLine()**
----
Gets the line of the book at which the user is at.

* **URL**

  ajax/ajax.php

* **Method:**
  
  `POST`
  
* **Data Params**

 **Required:**
 
   `method=getLine`

* **Success Response:**
  
  * **Code:** 200 <br />
    **Content:** `{ line : "This is an example line" }`
 
* **Sample Call:**

    ```js
    const xhttp = new XMLHttpRequest();
    const parameters = `method=getLine`;
    
    xhttp.onreadystatechange = () => {
        if (this.readyState === 4 && this.status === 200) {
            g.line = this.responseText;
        }
    };
    xhttp.open("POST", "../ajax/ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
    ```
    
**getLineId()**
----
Gets the line of the book at which the user is at.

* **URL**

  ajax/ajax.php

* **Method:**
  
  `POST`
  
* **Data Params**

 **Required:**
 
   `method=getLineId`

* **Success Response:**
  
  * **Code:** 200 <br />
    **Content:** `{ lineId : 121 }`
 
* **Sample Call:**

    ```js
    const xhttp = new XMLHttpRequest();
    const parameters = `method=getLineId`;

    xhttp.onreadystatechange = () => {
        if (this.readyState === 4 && this.status === 200) {
            // console.log("New line id: " + this.responseText)
        }
    };
    xhttp.open("POST", "../ajax/ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
    ```
   
**getSpeed()**
----
Gets the line of the book at which the user is at.

* **URL**

  ajax/ajax.php

* **Method:**
  
  `POST`
  
* **Data Params**

 **Required:**
 
   `method=getSpeed`

* **Success Response:**
  
  * **Code:** 200 <br />
    **Content:** `{ speed : 150 }`
 
* **Sample Call:**

    ```js
    const xhttp = new XMLHttpRequest();
    const parameters = `method=getSpeed`;

    xhttp.onreadystatechange = () => {
        if (this.readyState === 4 && this.status === 200) {
            g.wpmSelector.value = this.responseText + " wpm";
        }
    };
    xhttp.open("POST", "../ajax/ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
    ```
    
**getTotalLines()**
----
Gets the line of the book at which the user is at.

* **URL**

  ajax/ajax.php

* **Method:**
  
  `POST`
  
* **Data Params**

 **Required:**
 
   `method=getTotalLines`

* **Success Response:**
  
  * **Code:** 200 <br />
    **Content:** `{ totalLines : 8000 }`
 
* **Sample Call:**

    ```js
    const xhttp = new XMLHttpRequest();
    const parameters = `method=getTotalLines`;

    xhttp.onreadystatechange = () => {
        if (this.readyState === 4 && this.status === 200) {
            // console.log("Total Lines: " + this.responseText);
            g.totalLines = this.responseText;
        }
    };
    xhttp.open("POST", "../ajax/ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
    ```
    
**getTotalLines()**
----
Gets the line of the book at which the user is at.

* **URL**

  ajax/ajax.php

* **Method:**
  
  `POST`
  
* **Data Params**

 **Required:**
 
   `method=speed`

* **Success Response:**
  
  * **Code:** 200 <br />
 
* **Sample Call:**

    ```js
    const xhttp = new XMLHttpRequest();
    const parameters = `speed=${parseInt(g.wpmSelector.value.replace(' wpm', ''))}`;

    xhttp.onreadystatechange = () => {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
        }
    };
    xhttp.open("POST", "../ajax/ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parameters);
    ```
    