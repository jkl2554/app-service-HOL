App Service HOL
===================
## 시나리오
  ### **시나리오 1** - HOL 1, 2, 3
  ![웹앱 시나리오1](/img/시나리오1.png "시나리오 1")  
  ### **시나리오 2** - HOL 4
  ![웹앱 시나리오2](/img/시나리오2.png "시나리오 2")  
  ### **시나리오 3** - HOL 5
  ![웹앱 시나리오3](/img/시나리오3.png "시나리오 3")  
## HOL 준비 사항
- [Azure Portal](https://portal.azure.com/)에 접속 및 리소스를 생성할 수 있는 구독([Azure Pass](https://www.microsoftazurepass.com/))
- [Visual Studio Code 설치](https://code.visualstudio.com/)
- [git 설치](https://git-scm.com/downloads)
- [File Zilla Client 설치](https://filezilla-project.org/download.php?type=client)
- [샘플 리포지토리](https://github.com/Azure-Samples/laravel-tasks) 복제 혹은 다운로드  
    `git clone https://github.com/Azure-Samples/laravel-tasks`
# HOL 목차
[1. Web App 생성 및 게시](#1-Web-App-생성-및-게시)  
>   [1.1. Azure Web App 생성](#11-Azure-Web-App-생성)  
    [1.2. MySQL In App 생성](#12-MySQL-In-App-생성)  
    [1.3. 배포 설정](#13-MySQL-In-App-생성)  
    [1.4. FTP 배포](#14-FTP-배포)  
    [1.5. Git 배포](#15-Git-배포)  
    [1.6. 샘플 앱 빌드](#16-샘플-앱-빌드)  
    [1.7. 앱 구성 설정](#17-앱-구성-설정)  

[2. Production App에 DB 구성](#2-Production-App에-DB-구성)  
>   [2.1 배포 슬롯 생성](#21-배포-슬롯-생성)  
    [2.2 Production DB 생성](#22-Production-DB-생성)  
    [2.3 앱 구성으로 Production DB 연결](#23-앱-구성으로-Production-DB-연결)  
    [2.4 MySQL In App DB Export 작업](#24-MySQL-In-App-DB-Export-작업)  
    [2.5 App Service 편집기로 DB SSL 연결 구성](#25-App-Service-편집기로-DB-SSL-연결-구성)  

[3. Visual Studio Code & App Service](#3-Visual-Studio-Code-&-App-Service)  
>   [3.1 Visual Studio Code를 통해 배포 슬롯에 배포](#31-Visual-Studio-Code를-통해-배포-슬롯에-배포)  
    [3.2 Visual Studio Code로 Swap Slot](#32-Visual-Studio-Code로-Swap-Slot)  

[4. Traffic Manager](#4-Traffic-Manager)  
>   [4.1 앱 복제를 통해 다른 지역에 배포](#41-앱-복제를-통해-다른-지역에-배포)  
    [4.2 Traffic Manager 생성](#42-Traffic-Manager-생성)  
    [4.3 Traffic Manager 설정](#43-Traffic-Manager-설정)  

[5. Web App VNet 통합](#5-Web-App-VNet-통합)  
>   [5.1 Azure 가상 네트워크 생성](#51-Azure-가상-네트워크-생성)  
    [5.2 Web App VNet 통합 구성](#52-Web-App-VNet-통합-구성)  
    [5.3 DB 서비스 엔드포인트를 통해 VNet 통합 확인](#53-DB-서비스-엔드포인트를-통해-VNet-통합-확인)  
[6. 리소스 정리](#6-리소스-정리)    


# 1. Web App 생성 및 게시
## 1.1. Azure Web App 생성
### **위치 : Azure Potal 메인 - 리소스 만들기 블레이즈**
웹앱 검색 후 웹앱 선택하여 만들기  
   
![웹앱 생성 1](/img/1.1-01.png "웹앱 생성 1")  
  
### **리소스 정보**
  
**프로젝트 세부 정보**
- 구독 : 사용 가능한 구독
- 리소스 그룹 : 새로 만들기 -> AppService-HOL  
  
**인스턴스 정보**
- 이름 : `<이니셜+HP뒷자리>`
- 게시 : 코드
- 런타임 스택 : PHP 7.2
- 운영 체제 : Windows
- 지역 : KoreaCentral  
  
**App Service 계획**
- Windows 플랜 (Korea Central) : default
- Sku 및 크기 : Premium V2 P1v2
  
![웹앱 생성 2](/img/1.1-02.png "웹앱 생성 2")  
  
## 1.2. MySQL In App 생성
### **위치 : `<Your Web App>` - 설정 - MySQL In App 블레이즈**
- MySQL In App : 설정
- 저장

![MySQL In App 생성](/img/1.2-01.png "MySQL In App 생성")  

## 1.3. 배포 설정
### **위치 : `<Your Web App>` - 배포 - 배포 센터 블레이즈**
  
### **배포 설정 정보**
- 소스제어 : Local Git
- 빌드 공급자 : App Service 빌드 서비스

  
![배포 설정 1](/img/1.3-01.png "배포 설정 1")  
  
![배포 설정 2](/img/1.3-02.png "배포 설정 2")

## 1.4. FTP 배포
### **위치 : `<Your Web App>` - 배포 - 배포 센터 블레이즈**
### 상단의 FTP/자격 증명 버튼으로 자격증명 생성  
### **자격 증명 설정 정보**
- **사용자 자격증명**
- 사용자 이름 : <이니셜+HP뒷자리>
- 암호 : <비밀번호>  
생성된 자격증명을 아래 그림과 같이 입력해 FTP연결 가능
- git 연결을 위해 Git Clone URI 내용 저장   
  
![FTP 설정](/img/1.4-01.png "FTP 설정")  
  

### **위치 : FileZilla - FTP Connect `<Your Web App>`**
### FTP 연결을 통해 앱 배포
- 위에서 생성한 자격증명으로 FTP 로그인
- 디렉토리 생성(/site/wwwroot/dbinfo)
- 생성된 디렉토리에 [index.pnp](/dbinfo/index.php)파일 업로드  
  
![FTP 연결 및 배포](/img/1.4-02.png "FTP 연결 및 배포")  

### **위치 : https://`<Your Web App>`.azurewebsite.net/dbinfo/**
### 인터넷 브라우저에서 앱 확인
- 인터넷 브라우저로 배포한 앱 확인
- 브라우저에 표기된 Local DB 정보 저장
  
![배포한 앱 확인](/img/1.4-03.png "배포한 앱 확인")  
  
## 1.5. Git 배포
### **위치 : 샘플 리포지토리 폴더**
### Git Bash를 통해 소스 수정 및 앱 배포
- 샘플 리포지토리 폴더 우클릭 - Git Bash Here
- `touch .env`명령으로 .env파일 생성
- 편집기로 .env 파일에 브라우저에서 복사한 내용 붙여넣기
- 아래 명령으로 git 배포 수행
    ```
    git remote add azure <Git Clone URI>
    git add . -f
    git commit -m "App Push"
    git push azure master
    ```
- push 명령 수행 시 로그인 창에 자격 증명으로 로그인  
`* 자격증명을 잘못 기입했을 경우 자격 증명 관리자에서 해당 자격증명을 삭제하고 다시 push수행`
- push가 완료되면 아래와 같이 배포센터에서 확인 가능  
  
![git push 확인](/img/1.5-01.png "git push 확인")  
## 1.6. 샘플 앱 빌드
### **위치 : `<Your Web App>` - 개발도구 - 고급 도구 블레이즈 - 이동 - Kudu 페이지 - Debug console - PowerShell**
### Kudu Debug console을 활용한 앱 빌드  
  
![Kudu Debug console 접속](/img/1.6-01.png "Kudu Debug console 접속")  
  

- Directory 이동
    ```powershell
    PS D:\home> cd D:\home\site\wwwroot
    ```
- Power Shell 명령으로 필요한 패키지 설치
    ```powershell
    PS D:\home\site\wwwroot> php composer.phar install
    ```
- .env에 설정한 DB에 artisan migrate
    ```powershell
    PS D:\home\site\wwwroot> php artisan migrate
    ```
- artisan APP_KEY Generate
    ```powershell
    PS D:\home\site\wwwroot> php artisan key:generate
    ```
- APP_KEY Generate 출력에서 <APP_KEY> 저장
    ```powershell
    php artisan key:generate
    **************************************
    *     Application In Production!     *
    **************************************

    Do you really wish to run this command? (yes/no) [no]:
    > y
    ……

    Application key [<APP_KEY>] set successfully.

    ```

## 1.7. 앱 구성 설정
### **위치 : `<Your Web App>`**
### 설정 - 구성 블레이즈
- 응용프로그램 설정 - 새 응용프로그램 설정에 APP_KEY 변수 등록  
     이름 : APP_KEY  
     값 : <APP_KEY>  
       
    ![APP_KEY 등록](/img/1.7-01.png "APP_KEY 등록")  
- 경로매핑 -  새 가상 어플리케이션 또는 디렉터리  
    가상 경로 : /dbinfo  
    실제 경로 : site\wwwroot\dbinfo  
- 가상경로가 /인 응용프로그램 실제 경로 설정 변경  
    실제 경로 : site\wwwroot\public  
- 해당 작업 완료 후 저장  
  
    ![경로 매핑](/img/1.7-02.png "경로 매핑")  

### **위치 : https://`<Your Web App>`.azurewebsites.net/** 
### 인터넷 브라우저에서 배포한 앱 확인
![앱 확인](/img/1.7-03.png "앱 확인")  
  
# 2. Production App에 DB 구성
## 2.1 배포 슬롯 생성
### **위치 : `<Your Web App>`**
### 배포 - 배포 슬롯 블레이즈
- 슬롯 추가
    이름 : Staging
    다음의 설정 복제 : `<Your Web App>`

    ![배포 슬롯 추가](/img/2.1-01.png "배포 슬롯 추가")  
    
## 2.2 Production DB 생성
### **위치 : Azure Portal 메인 - 리소스 만들기 - mysql 검색 - Azure Database for MySQL**
### Azure MySQL Database 생성 작업 수행
  
  ![DB 생성](/img/2.2-01.png "DB 생성")  
    
### **리소스 정보**
  
**프로젝트 세부 정보**
- 구독 : `<Your Web App>`이 생성된 구독
- 리소스 그룹 : AppService-HOL  
  
**서버 정보**
- 서버 이름 : `<이니셜+HP뒷자리>`-mysql
- 데이터 원본 : 없음
- 관리 사용자 이름 : `<Your Username>`
- 암호 및 암호 확인 : `<Your Password>`
- 위치 : (아시아 태평양)한국 중부
- 버전 : 5.7
- 컴퓨팅 + 스토리지 : default
      
    ![DB 생성](/img/2.2-02.png "DB 생성")  
### **위치 : `<Your DB>` - 설정 - connection security 블레이즈**
### 초기 연결을 위한 설정 수행
- Allow access to Azure services : ON  
- Enforce SSL connection : DISABLED  
  
![DB Settings](/img/2.2-03.png "DB Settings")  
## 2.3 앱 구성으로 Production DB 연결  
### **위치 : `<Your DB>` - 설정 - connection strings 블레이즈**
### connection string `<Your Web App>`에 설정
- 웹앱 connection string 저장 및 수정작업 수행
  
![DB connection string](/img/2.3-01.png "DB connection string")  
  
 ```
 Database=<Your Database>; Data Source=<Your Host>; User Id=<Your User Id>; Password=<Your Password>
 ```
- `<Your Database>`값은 임의로 설정  
- `<Your Password>`값은 `<Your DB>`의 `<Your Password>`에 설정한 비밀번호  
- 나머지는 default값 사용해서 저장(`<connection string>`)
### **위치 : 편집기**
### 응용 프로그램 설정 배포를 위한 json 생성
- 편집기에 아래 내용을 붙여넣는다.
    ```json
    {
        "name": "DB_CONNECTION",
        "value": "mysql",
        "slotSetting": true
    },
    {
        "name": "DB_DATABASE",
        "value": "<Your Database>",
        "slotSetting": true
    },
    {
        "name": "DB_HOST",
        "value": "<Your Host>",
        "slotSetting": true
    },
    {
        "name": "DB_PASSWORD",
        "value": "<Your Password>",
        "slotSetting": true
    },
    {
        "name": "DB_PORT",
        "value": "3306",
        "slotSetting": true
    },
    {
        "name": "DB_USERNAME",
        "value": "<Your User Id>",
        "slotSetting": true
    },
    ```
- `<connection string>`에서 json 에 매치되는 값을 집어넣어 저장(`<connection json>`)
  
### **위치 : <Your Web App> - 구성 - 응용 프로그램 설정**
### 연결 문자열 및 응용 프로그램 설정 추가
- 새 연결 문자열 추가
    - 이름 : production_db
    - 값 : `<connection string>`
    - 형식 : MySQL
    - 배포 슬롯 설정 : 체크  
      
    ![Add DB connection string](/img/2.3-02.png "Add DB connection string")
- 응용 프로그램 설정 - 고급 편집
    - 아래와 같이 상단에 `<connecion json>`내용 추가
```
[
    <connection json>
    
    ....

]
```
  
![Add DB connection json](/img/2.3-03.png "Add DB connection json")  
  
- 응용 프로그램 설정에 추가한 `<connection json>`에 배포슬롯 설정이 체크된 것 확인  
  
    ![Check DB connection json](/img/2.3-04.png "Check DB connection json")  
  
## 2.4 MySQL In App DB Export 작업
### **위치 : https://<Your Web App>.scm.azurewebsite.net/phpMyAdmin/**
### `<production DB>`생성
- phpMyAdmin에서 `<Your Host>`에 연결된 connection 선택
- New 메뉴에서 `<production DB>`생성
  
    ![Select DB connection](/img/2.4-01.png "Select DB connection")   
    
    ![Create DB](/img/2.4-02.png "Create DB")   
    
### **위치 : `<Your Web App>` - 설정 - MySQL In App**
### 데이터 내보내기
- 하단에 가져오기/내보내기
    - 작업 : 내보내기
    - 입력 형식 : 연결문자열
    - 연결 문자열 : `<connection string>`  
      
    ![Export DB connection](/img/2.4-03.png "Export DB connection")   
    
### **위치 : https://`<Your Web App>`.azurewebsites.net/**
### 인터넷 브라우저에서 앱 작동 확인
![Check DB Export](/img/2.4-03.png "Check DB Export")   
## 2.5 App Service 편집기로 DB SSL 연결 구성
### **위치 : `<Your DB>` - Connection security**
### SSL 연결 설정
- Enforce SSL connection : ENABLE  
  
    ![DB SSL connection setting](/img/2.5-01.png "DB SSL connection setting")   
  
### **위치 : https://`<Your Web App>`.azurewebsites.net/**
### 인터넷 브라우저에서 앱 동작 실패 확인
![DB SSL Not Connected](/img/2.5-02.png "DB SSL Not Connected")   
### **위치 : `<Your Web App>` - App Service 편집기(미리 보기) - 이동 - wwwroot/config/database.php**
### App Service 편집기를 통해 SSL 연결 소스 수정  
![App Service 편집기](/img/2.5-03.png "App Service 편집기")    
  
- database.php의 53-54줄 사이에 아래 코드 삽입
 ```
             'sslmode' => env('DB_SSLMODE', 'prefer'),
            'options' => (env('MYSQL_SSL')) ? [
                PDO::MYSQL_ATTR_SSL_KEY    => '/ssl/BaltimoreCyberTrustRoot.crt.pem', 
            ] : []
 ```
 ** SSL인증서는 편의를 위해 리포지토리에 미리 포함
 - 우측 상단의 SAVED 로 표기되어 있으면 수정사항이 저장된 것  
   
![SSL 소스 코드 편집](/img/2.5-04.png "SSL 소스 코드 편집")    
  
### **위치 : `<Your Web App>` - 설정 - 구성 - 응용 프로그램 설정**
### 응용 프로그램 설정에 MYSQL_SSL 추가
- 새 응용 프로그램 설정
   - 이름 : MYSQL_SSL
   - 값 : true
   - 배포 슬롯 설정 : 체크
- 확인 및 저장  
  
    ![SSL 응용 프로그램 설정](/img/2.5-05.png "SSL 응용 프로그램 설정")    
### **위치 : https://`<Your Web App>`.azurewebsites.net/**
### 인터넷 브라우저에서 앱 작동 확인
![SSL Connecion 동작 확인](/img/2.5-06.png "SSL Connecion 동작 확인")    
# 3. Visual Studio Code & App Service
### **위치 : FileZilla - FTP Connect `<Your Web App>`**
### Production App 파일 내려받기 작업
- `<Your Web App>`에 FTP로 연결해 빌드된 App을 다운로드 한다.(`<production app>`)  
  
    ![production app 내려받기](/img/3.1-01.png "production app 내려받기")    
## 3.1 Visual Studio Code를 통해 배포 슬롯에 배포
### **위치 : Visual Studio Code - open `<producion app>`**
### `<production app>`폴더를 열어 소스 수정 후 배포 슬롯에 배포
- Visual Studio Code - 탐색기 - 폴더열기 - `<production App>`선택  
  
    ![production app 폴더 열기](/img/3.1-02.png "production app 폴더 열기")    
  
- `<production app>`/routes/web.php 파일하단에 아래 코드 추가
```php
/**
 * Toggle Task completeness
 */
Route::post('/task/{id}', function ($id) {
    error_log('INFO: post /task/'.$id);
    $task = Task::findOrFail($id);

    $task->complete = !$task->complete;
    $task->save();

    return redirect('/');
});
```
  
![web.php 추가 위치](/img/3.1-03.png "web.php 추가 위치")    
빨간 화살표 위치에 해당 코드 추가  
- `<production app>`/resources/views/tasks.blade.php
```html
55      <tr>
56      <td class="table-text"><div>{{ $task->name }}</div></td>
```
- 위의 코드 아래와 같이 변경
```html
55 <tr class="{{ $task->complete ? 'success' : 'active' }}" >
56  <td>
57    <form action="{{ url('task/'.$task->id) }}" method="POST">
58        {{ csrf_field() }}
59
60        <button type="submit" class="btn btn-xs">
61            <i class="fa {{$task->complete ? 'fa-check-square-o' : 'fa-square-o'}}"></i>
62        </button>
63        {{ $task->name }}
64    </form>
65  </td>
```  
![tasks.blade.php 코드 수정](/img/3.1-04.png "tasks.blade.php 코드 수정")    

### **위치 : Visual Studio Code - 확장**
### Azure Account, Azure App Serivce 확장 설치
- Azure App Service 검색
- Azure Account, Azuer App Service 확장 설치  
  
    ![Azure 확장 설치](/img/3.1-05.png "Azure 확장 설치")    

### **위치 : Visual Studio Code - Azure - App Service**
### Azure 확장으로 배포작업 수행
- Web App이 배포된 구독에서 `<Your Web App>` - Devployment Slots - staging 우클릭
- Deploy to Slot 메뉴 선택  
  
    ![Azure 확장으로 슬롯에 배포](/img/3.1-06.png "Azure 확장으로 슬롯에 배포") 
      
### **위치 : https://`<Your Web App>`-staging.azurewebsites.net/dbinfo/**
### 배포작업 확인 및 Local DB 정보 확인
- 인터넷 브라우저로 배포한 앱 확인
- 브라우저에 표기된 Local DB 정보 저장(`<slot env>`)  
  
    ![배포 슬롯 앱 확인](/img/3.1-07.png "배포 슬롯 앱 확인")
      
### **위치 : https://`<Your Web App>`-staging.scm.azurewebsites.net/ - Debug console - PowerShell**
### Kudu 접속으로 Migration 생성
  
![Kudu 접속](/img/3.1-09.png "Kudu 접속") 
  
- Directory 이동
    ```powershell
    PS D:\home> cd D:\home\site\wwwroot
    ```
- 새로운 Migration 생성
    ```powershell
    PS D:\home\site\wwwroot> php artisan make:migration add_complete_column --table=tasks
    ```
- 생성 결과
    ```powershell
    php artisan make:migration add_complete_column --table=tasks 
    Created Migration: 2019_07_22_075436_add_complete_column 
    ```
    ** 위의 `Created Migration` 을 편의상 `<migration>`으로 표기  
  
### **위치 : Visual Studio Code - Azure - App Service**
### Visual Studio Code를 통한 Web App 코드 수정
- `<Your Web App>` - Devployment Slots - staging - Files - .env
  
    ![Azure 확장 App service](/img/3.1-10.png "Azure 확장 App service")

- 해당 파일 내용을 `<slot env>`로 변경 및 저장  
** 저장작업을 수행하면 아래 그림과 같이 업로드 할 것인지 묻는 대화상자가 나오고 출력창에 업데이트 현황이 표기된다.  
    ![Azure 확장 App service update](/img/3.1-11.png "Azure 확장 App service update")  
- `<Your Web App>` - Devployment Slots - staging - Files - database - migrations - `<migration>`
  
    ![Migration 파일 위치](/img/3.1-12.png "Migration 파일 위치")
  
- function up(), function douwn()을 아래와 같이 수정한다. 
    ```
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
        $table->boolean('complete')->default(False);
        });
    }
    ```
    ```
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn('complete');
        });
    }

    ```
    ![Migration 파일 수정](/img/3.1-13.png "Migration 파일 수정")
      
### **위치 : https://`<Your Web App>`-staging.scm.azurewebsites.net/ - Debug console - PowerShell**
### Kudu 접속으로 Local DB 업데이트 작업 수행
```
PS D:\home>cd site/wwwroot
PS D:\home\site\wwwroot> php artisan migrate
php artisan migrate
**************************************
*     Application In Production!     *
**************************************

 Do you really wish to run this command? (yes/no) [no]:
 > y 
```
### **위치 : https://`<Your Web App>`-staging.azurewebsites.net/**
### 인터넷 브라우저에서 staging slot 앱 작동 확인
![staging slot 작동 확인](/img/3.1-14.png "staging slot 작동 확인")

## 3.2 Visual Studio Code로 Swap Slot
### **위치 : Visual Studio Code - Azure - App Service**
### Visual Studio Code를 이용한 Slot Swap 작업 수행
- `<Your Web App>` - Devployment Slots - staging 우클릭 Swap Deployment Slot 실행  
  
    ![swap slot](/img/3.2-01.png "swap slot")
### **위치 : https://`<Your Web App>`.scm.azurewebsites.net/ - Debug console - PowerShell**
### Kudu 접속으로 `<Your DB>` 업데이트 작업 수행
```
PS D:\home>cd site/wwwroot
PS D:\home\site\wwwroot> php artisan migrate
php artisan migrate
**************************************
*     Application In Production!     *
**************************************

 Do you really wish to run this command? (yes/no) [no]:
 > y 
```
### **위치 : https://`<Your Web App>`.azurewebsites.net/**
### 인터넷 브라우저에서 Production 앱 작동 확인
![production app](/img/3.2-03.png "production app")
### **위치 : https://`<Your Web App>`-staging.azurewebsites.net/**
### 인터넷 브라우저에서 staging slot 앱 작동 확인
![staging slot app](/img/3.2-04.png "staging slot app")  
**staging slot은 소스 업데이트 전 app이 실행된다.
      
# 4. Traffic Manager
## 4.1 앱 복제를 통해 다른 지역에 배포
### **위치 : `<Your Web App>` - 개발도구 - 앱 복제**
### Web App 복제 작업 수행
- 앱 이름 : `<Your Web App>`cus (`<Clone Web App>`)
- 리소스 그룹 : AppService-CUS(새로 만들기)
- App Service 계획/위치
    - 새로만들기
        - 이름 : CUS-plan
        - 위치 : Central US
        - 가격 책정 계층 : P1v2  
*앱 복제가 정상적으로 작동하지 않을 경우 [앱 백업](https://docs.microsoft.com/ko-kr/azure/app-service/manage-backup) & [앱 복원](https://docs.microsoft.com/ko-kr/azure/app-service/web-sites-restore) 사용 필요
    
![Clone App](/img/4.1-02.png "Clone App")  
## 4.2 Traffic Manager 생성
### **위치 : Azure Portal 메인 - 리소스 만들기 - traffic manager profile 검색 - 트래픽 관리자 프로필 생성**
### Traffic Manager 프로필 생성 작업 수행 
- 이름 : `<Your Web App>`tm (`<Your Traffic Manager>`)
- 라우팅 방법 : 성능
- 구독 : `<Your Web App>`가 생성된 구독
- 리소스 그룹 : AppService-HOL
  
![Make Traffic Manager](/img/4.2-01.png "Make Traffic Manager")
    
## 4.3 Traffic Manager 설정
### **위치 : `<Your Traffic Manager>` - 설정 - 엔드포인트**
### Traffic Manager 엔드포인트 추가
- 추가
    - 형식 : Azure 엔드포인트
    - 이름 : `<Your Web App>`kor
    - 대상 리소스 형식 : App Service
    - 대상 리소스 : `<Your Web App>`
- 추가
    - 형식 : Azure 엔드포인트
    - 이름 : `<Your Web App>`cus
    - 대상 리소스 형식 : App Service
    - 대상 리소스 : `<Clone Web App>`
  
![EndPoint 추가](/img/4.3-01.png "EndPoint 추가")
### **위치 : `<Your Traffic Manager>` - 개요**
### Traffic Manager DNS 이름 확인
- DNS 이름 저장  
 
    ![Traffic Manager DNS](/img/4.3-02.png "Traffic Manager DNS")
    
### **위치 : https://geopeeker.com/**
### Traffic Test
- `<Your Web App>` 주소로 테스트한 결과  
  
    ![Web App test](/img/4.3-03.png "Web App test")
     
- `<Your Traffic Manager>` 주소로 테스트한 결과  
  
    ![Traffic Manager test](/img/4.3-04.png "Taffic Manager test")
# 5. Web App VNet 통합
## 5.1 Azure 가상 네트워크 생성
### **위치 : Azure Portal 메인 - 리소스 만들기 - 가상 네트워크 검색 - 가상네트워크 생성**
### Web App과 통합할 가상 네트워크 생성 
- 이름 : Webapp-vnet
- 주소 공간 : 10.0.0.0/16
- 구독 : `<Your Web App>`가 생성된 구독
- 리소스 그룹 : AppService-HOL
- 위치 : (아시아 태평양)한국 중부
- 서브넷
    - 이름 : frontend
    - 주소 범위 : 10.0.0.0/24
    - DDoS 보호 : 기본
    - 서비스 엔드포인트 : 사용
    - 서비스 : Microsoft.Sql
    - 방화벽 : 사용안함  
    
![가상 네트워크 생성](/img/5.1-01.png "가상 네트워크 생성")
## 5.2 Web App VNet 통합 구성
### **위치 : `<Your Web App>` - 설정 - 네트워킹 - VNet 통합 구성하기**
### VNet 통합 구성 및 설정
- VNet 추가(미리보기)
    - Virtual Network : Webapp-vnet
    - 서브넷 : frontend (기존 항목 선택)  

    ![VNet 추가 구성](/img/5.2-02.png "VNet 추가 구성")  

## 5.3 DB 서비스 엔드포인트를 통해 VNet 통합 확인
### **위치 : `<Your DB>` - 설정 - Connection security**
### VNET rules 생성 및 Azure Resource 접근 거부
- Allow access to Azure services : OFF
- VNET rules : + Adding existing virtual network
    - Name : vnet-conn
    - Subscription : `<Your Web App>`가 생성된 구독
    - Virtual network : Webapp-vnet
    - Subnet name / Address prefix : frontend / 10.0.0.0/24  
    
    ![VNET rules setting](/img/5.3-01.png "VNET rules setting") 


### **위치 : https://`<Clone Web App>`.azurewebsites.net/**
### Clone Web App 접속 장애 확인
![Clone App not conn DB](/img/5.3-02.png "Clone App not conn DB") 
### **위치 : https://`<Your Web App>`.azurewebsites.net/**
### Your Web App
![Web App conn DB](/img/5.3-03.png "Web App conn DB") 
### **위치 : https://geopeeker.com/**
### Traffic Manager DNS를 활용한 접속 테스트
- `<Your Traffic Manager>` DNS에 글로벌 접속 테스트  
  
    ![Traffic Manager conn Your Web App](/img/5.3-04.png "Traffic Manager conn Your Web App") 

# 6. 리소스 정리
### **위치 : Azure Portal 메인 - 리소스 그룹**
### 리소스 그룹 삭제 작업 수행
- AppServie-CUS, AppServie-HOL, NetworkWatchRG 리소스그룹 삭제 수행  
  
    ![remove RG](/img/6.png "remove RG")

