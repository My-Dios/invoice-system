# Invoice System
<div align="center" style='text-align : center;'>
  <div class='row'>
    <img src="https://img.freepik.com/free-icon/report_318-373693.jpg" width="250px"/>
  </div>
  <br>
  <i>The All-in-One Integerated Invoice System</i>
  <br>
</div>

<br>
<div align="center">
<img src="https://img.shields.io/badge/version-v1.0.0-blue" />
</div>

## System Requirement
**System Operations:** Windows or Unix Base

**PHP** = 7.4

**MySQL** = 5.6

**Composer** = 2.5.8

**Yii2** = 2.0.4

## Development Setup

### Prerequisites
<ul>
    <li><a href="https://code.visualstudio.com/download" target="_blank" rel="noopener noreferrer">Visual Studio Code</a></li>
    <li><a href="https://dev.mysql.com/downloads/workbench/" target="_blank" rel="noopener noreferrer">DBMS</a></li>
    <li><a href="https://www.postman.com/downloads/" target="_blank" rel="noopener noreferrer">Postman</a></li>
    <li><a href="https://git-scm.com/downloads" target="_blank" rel="noopener noreferrer">Git</a></li>
    <li><a href="https://www.php.net/downloads.php" target="_blank" rel="noopener noreferrer">PHP</a></li>
    <li><a href="https://getcomposer.org/download/" target="_blank" rel="noopener noreferrer">Composer</a></li>
</ul>

### Setting Up a Project
<b>Clone the project</b>
<br>
clone into your directory
```bash
git clone https://github.com/My-Dios/invoice-system.git
```

<b>Create 1 New Schema</b> 
<br>
Open your DBMS and create 1 new schema:  
<ol>
    <li>esb_invoice</li>
</ol>

<b>API's Collection</b> 
<br>
Import <a href="https://drive.google.com/file/d/1U8A9BKlGWX92riqZFONCxSiKv-hcAs14/view?usp=sharing" target="_blank" rel="noopener noreferrer">API's Collection</a> to Postman 

<b>Migration</b>
<br>
Migrate the Migration File 
```bash
php yii migrate
```

<b>Composer</b>
<br>
Install the Composer 
```bash
composer install
```

<b>UUID</b>
<br>
Install UUID from Ramsey
```bash
composer require ramsey/uuid
```

<b>Run the project</b>
<br>
```bash
php yii serve
```


### Usage a Project
<b>1. Run the Project</b> 
<br>

<b>2. Open API's Collection</b> 
<br>
Open API's Collection in Postman

<b>3. Base URL</b> 
<br>
You must setting your base url in variable API's Collection, adjust the url when running `php yii serve`

<b>4. Testing</b> 
<br>
You can test the API `Create Transaction` but you must adjustment key value customerID in `Get All Customer` API and key value itemID in `Get All Item` API 


## Version
| Version | Date         | Update |
| :---:   |     :---:    |  ---   |
| `1.0.0`| `2023-25-06` | <ul><li>Initial Version</li></ul> |
