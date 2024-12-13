<?php
require "connection.php";
if(isset($_POST['studentName'])){
    $studentname=$_POST['studentName'];

    $coursename=$_POST['course'];
    $classname=$_POST['class'];
    $levelname=$_POST['level'];
// here u are creating table for the students of each course (course includes coursename and class(batch)name)

    $courseandclass=$coursename.$levelname."class".$classname;
    switch($courseandclass){
        case 'ACFNs24class5':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'ACFNs24class6':
            $tablename="class".$coursename."C".$classname; 
            break;       
        case 'ACFN24class3':
            $tablename="class".$coursename."C".$classname; 
            break;
            
        case 'ACFN24class4':
            $tablename="class".$coursename."C".$classname;     
            break;

        case 'ACFN24class6':
            $tablename="class".$coursename."C".$classname;  
            break;
        
        case 'CNA24class4':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'CNA24class5':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'CNA24class6':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'CNA24class7':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'DMA24class1':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'DMA24class2':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'DMA24class3':
            $tablename="class".$coursename."C".$classname;
            break;
        case 'FRENCH24class1':
            $tablename="class".$coursename."C".$classname;
            break;



            case 'IT24class4':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'IT24class5':
                $tablename="class".$coursename."C".$classname;
                break;
                
            case 'BM24class2':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'BM24class3':
                $tablename="class".$coursename."C".$classname;
                break;         
            case 'CB24class4':
                $tablename="class".$coursename."C".$classname;  
                break;
            case 'CB24class5':
                $tablename="class".$coursename."C".$classname; 
                break;
            case 'PLMB24class1':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'PLMB24class2':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'AM24class1':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'AM24class2':
                $tablename="class".$coursename."C".$classname;
                break;
            case 'IELTS24class1':
                $tablename="class".$coursename."C".$classname;
                break;
               
                
                
                case 'ENG24A0class1':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24A1class4':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24A1class5':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24A1class6':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24A2class4':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                    case 'ENG24A2class5':
                        $tablename="class".$coursename.$levelname."C".$classname;
                        break;    
                case 'ENG24B1class1':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24B2class1':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24B2class2':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
                case 'ENG24B1class2':
                    $tablename="class".$coursename.$levelname."C".$classname;
                    break;
        }
        if (!empty($tablename)) {
            $stmt = $conn->prepare("INSERT INTO $tablename (studentname, coursename, classname, levelname) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $studentname, $coursename, $classname, $levelname);
    
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Record inserted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "invalid course or class configuration."]);
        }
    
        $conn->close();
    }
    ?>