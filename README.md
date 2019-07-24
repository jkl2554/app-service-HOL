App Service HOL
===================
## HOL 준비 사항
- [Azure Portal](https://portal.azure.com/)에 접속 및 리소스를 생성할 수 있는 구독([Azure Pass](https://www.microsoftazurepass.com/))
- [Visual Studio Code 설치](https://code.visualstudio.com/)
- [git 설치](https://git-scm.com/downloads)
- [File Zilla Client 설치](https://filezilla-project.org/download.php?type=client)
- [샘플 리포지토리](https://github.com/Azure-Samples/laravel-tasks) 복제 혹은 다운로드  
    `git clone https://github.com/Azure-Samples/laravel-tasks`
# HOL 목차
[1. Web App 생성 및 게시](#1.-Web-App-생성-및-게시)  
>   [1.1. Azure Web App 생성](#1.1.-Azure-Web-App-생성)  
    [1.2. MySQL In App 생성](#1.2.-MySQL-In-App-생성)  
    [1.3. 배포 설정](#1.2.-MySQL-In-App-생성)  
    [1.4. FTP 배포](#1.4.-FTP-배포)  
    [1.5. Git 배포](#1.5.-Git-배포)  
    [1.6. 샘플 앱 빌드](#1.6.-샘플-앱-빌드)  
    [1.7. 앱 구성 설정](#1.7.-앱-구성-설정)  

[2. Production 구성](#2.-Production-구성)  
>   [2.1 배포 슬롯 생성](#2.1-배포-슬롯-생성)  
    [2.2 Production DB 생성](#2.2-Production-DB-생성)  
    [2.3 앱 구성으로 Production DB 연결](#2.3-앱-구성으로-Production-DB-연결)  
    [2.4 MySQL In App DB Migration 작업](#2.4-MySQL-In-App-DB-Migration-작업)  
    [2.5 App Service 편집기로 DB SSL 연결 구성](#2.5-App-Service-편집기로-DB-SSL-연결-구성)  

[3. Visual Studio Code & App Service](#3.-Visual-Studio-Code-&-App-Service)  
>   [3.1 Visual Studio Code를 통해 배포 슬롯에 배포](#3.1-Visual-Studio-Code를-통해-배포-슬롯에-배포)  
    [3.2 Visual Studio Code로 Swap Slot](#3.2-Visual-Studio-Code로-Swap-Slot)  

[4. Traffic Manager](#4.-Traffic-Manager)  
>   [4.1 앱 복제를 통해 다른 지역에 배포](#4.1-앱-복제를-통해-다른-지역에-배포)  
    [4.2 Traffic Manager 생성](#4.2-Traffic-Manager-생성)  
    [4.3 Traffic Manager 설정](#4.3-Traffic-Manager-설정)  

[5. Web App VNet 통합](#5.-Web-App-VNet-통합)  
>   [5.1 Azure 가상 네트워크 생성](#5.1-Azure-가상-네트워크-생성)  
    [5.2 Web App VNet 통합 구성](#5.2-Web-App-VNet-통합-구성)  
    [5.3 DB 서비스 엔드포인트를 통해 VNet 통합 확인](#5.3-DB-서비스-엔드포인트를-통해-VNet-통합-확인)  


# 1. Web App 생성 및 게시
## 1.1. Azure Web App 생성
### **위치 : `Azure Potal 메인`**
### 리소스 만들기 블레이즈
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
### **위치 : `<Your Web App>`**
### 설정 - MySQL In App 블레이즈
- MySQL In App : 설정
- 저장

![MySQL In App 생성](/img/1.2-01.png "MySQL In App 생성")  

## 1.3. 배포 설정
### **위치 : `<Your Web App>`**
### 배포 - 배포 센터 블레이즈
  
### **배포 설정 정보**
- 소스제어 : Local Git
- 빌드 공급자 : App Service 빌드 서비스
  
![배포 설정 1](/img/1.3-01.png "배포 설정 1")  
  
![배포 설정 2](/img/1.3-02.png "배포 설정 2")

## 1.4. FTP 배포
### **위치 : `<Your Web App>`**
### 배포 - 배포 센터 블레이즈
상단의 FTP/자격 증명 버튼으로 자격증명을 생성한다.  
### **자격 증명 설정 정보**
- **사용자 자격증명**
- 사용자 이름 : cloocus
- 암호 : <비밀번호>  
생성된 자격증명으로 아래와 같이 FTP 연결 가능  
  
![FTP 설정](/img/1.4-01.png "FTP 설정")  
  

### **위치 : FileZilla**
### FTP 연결을 통해 앱 배포
- 위에서 생성한 자격증명으로 FTP 로그인
- 디렉토리 생성(/site/wwwroot/dbinfo)
- 생성된 디렉토리에 [index.pnp](/dbinfo/index.php)파일 업로드  
  
![FTP 연결 및 배포](/img/1.4-02.png "FTP 연결 및 배포")  

### **위치 : Chrome**
### 배포한 앱 확인
- Chrome 브라우저에서 `https://<Your Web App Name>.azurewebsite.net/dbinfo/`에 접속


## 1.5. Git 배포
## 1.6. 샘플 앱 빌드
## 1.7. 앱 구성 설정
# 2. Production 구성
## 2.1 배포 슬롯 생성
## 2.2 Production DB 생성
## 2.3 앱 구성으로 Production DB 연결
## 2.4 MySQL In App DB Migration 작업
## 2.5 App Service 편집기로 DB SSL 연결 구성
# 3. Visual Studio Code & App Service
## 3.1 Visual Studio Code를 통해 배포 슬롯에 배포
## 3.2 Visual Studio Code로 Swap Slot
# 4. Traffic Manager
## 4.1 앱 복제를 통해 다른 지역에 배포
## 4.2 Traffic Manager 생성
## 4.3 Traffic Manager 설정
# 5. Web App VNet 통합
## 5.1 Azure 가상 네트워크 생성
## 5.2 Web App VNet 통합 구성
## 5.3 DB 서비스 엔드포인트를 통해 VNet 통합 확인
# 6. 리소스 정리

