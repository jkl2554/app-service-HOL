App Service HOL
===================
## HOL 준비 사항
- [Azure Portal](https://portal.azure.com/)에 접속할 수 있는 계정 및 사용할 수 있는 구독([Azure Pass](https://www.microsoftazurepass.com/))
- [Visual Studio Code 설치](https://code.visualstudio.com/)
- [git 설치](https://git-scm.com/downloads)
- [File Zilla Client 설치](https://filezilla-project.org/download.php?type=client)
- [샘플 리포지토리](https://github.com/Azure-Samples/laravel-tasks) 복제 혹은 다운로드  
    `git clone https://github.com/Azure-Samples/laravel-tasks`
---
## HOL 목차
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


---
## 1. Web App 생성 및 게시
### 1.1. Azure Web App 생성
![웹앱 생성 1](/img/1.1-01.png "웹앱 생성 입니다")
### 1.2. MySQL In App 생성
### 1.3. 배포 설정
### 1.4. FTP 배포
### 1.5. Git 배포
### 1.6. 샘플 앱 빌드
### 1.7. 앱 구성 설정
## 2. Production 구성
### 2.1 배포 슬롯 생성
### 2.2 Production DB 생성
### 2.3 앱 구성으로 Production DB 연결
### 2.4 MySQL In App DB Migration 작업
### 2.5 App Service 편집기로 DB SSL 연결 구성
## 3. Visual Studio Code & App Service
### 3.1 Visual Studio Code를 통해 배포 슬롯에 배포
### 3.2 Visual Studio Code로 Swap Slot
## 4. Traffic Manager
### 4.1 앱 복제를 통해 다른 지역에 배포
### 4.2 Traffic Manager 생성
### 4.3 Traffic Manager 설정
## 5. Web App VNet 통합
### 5.1 Azure 가상 네트워크 생성
### 5.2 Web App VNet 통합 구성
### 5.3 DB 서비스 엔드포인트를 통해 VNet 통합 확인
## 6. 리소스 정리

