<?php
require "connection.php";
if(isset($_POST['studentName'])){
    $studentname=$_POST['studentName'];

    $coursename=$_POST['course'];
    $classname=$_POST['class'];
    $levelname=$_POST['level'];
// here u are creating table for the students of each course (course includes coursename and class(batch)name)

    $courseandclass=$coursename.$levelname."class".$classname;
    $tablename="class".$coursename.$levelname."c".$classname;
    // switch($courseandclass){
    //     case 'acfn24class5':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'acfn24class6':
    //         $tablename="class".$coursename."c".$classname; 
    //         break;       
    //     case 'acfn24class3':
    //         $tablename="class".$coursename."c".$classname; 
    //         break;
            
    //     case 'acfn24class4':
    //         $tablename="class".$coursename."c".$classname;     
    //         break;

    //     case 'acfn24class6':
    //         $tablename="class".$coursename."c".$classname;  
    //         break;
        
    //     case 'cna24class4':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'cna24class5':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'cna24class6':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'cna24class7':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'dma24class1':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'dma24class2':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'dma24class3':
    //         $tablename="class".$coursename."c".$classname;
    //         break;
    //     case 'french24class1':
    //         $tablename="class".$coursename."c".$classname;
    //         break;



    //         case 'it24class4':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'it24class5':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
                
    //         case 'bm24class2':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'bm24class3':
    //             $tablename="class".$coursename."c".$classname;
    //             break;         
    //         case 'cb24class4':
    //             $tablename="class".$coursename."c".$classname;  
    //             break;
    //         case 'cb24class5':
    //             $tablename="class".$coursename."c".$classname; 
    //             break;
    //         case 'plmb24class1':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'plmb24class2':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'am24class1':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'am24class2':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
    //         case 'ielts24class1':
    //             $tablename="class".$coursename."c".$classname;
    //             break;
               
            
                
    //             case 'eng24a0class1':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24a1class4':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24a1class5':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24a1class6':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24a2class4':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //                 case 'eng24a2class5':
    //                     $tablename="class".$coursename.$levelname."c".$classname;
    //                     break;    
    //             case 'eng24b1class1':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24b2class1':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24b2class2':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //             case 'eng24b1class2':
    //                 $tablename="class".$coursename.$levelname."c".$classname;
    //                 break;
    //     }
    if (!empty($tablename)) {
        // Check for duplicate studentname
        $checkStmt = $conn->prepare("SELECT COUNT(*) AS count FROM $tablename WHERE studentname = ?");
        $checkStmt->bind_param("s", $studentname);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
    
        if ($row['count'] > 0) {
            echo json_encode(["status" => "error", "message" => "Duplicate entry: Student name already exists."]);
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO $tablename (studentname, coursename, classname, levelname) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $studentname, $coursename, $classname, $levelname);
    
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Record inserted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => $stmt->error]);
            }
            $stmt->close();
        }
        $checkStmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid course or class configuration."]);
    }
    
    
        $conn->close();
    }
    ?>

    