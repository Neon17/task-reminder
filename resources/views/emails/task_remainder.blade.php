<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Reminder</title>
    <style type="text/css">
        /* Base Styles */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f7fafc;
            color: #4a5568;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            width: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        /* Main Container */
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
        }
        
        /* Content Box */
        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 5%;
            margin-bottom: 20px;
            width: 90%;
        }
        
        /* Header */
        .header {
            color: #3182ce;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        /* Text Elements */
        .greeting {
            font-size: 15px;
            color: #718096;
            margin-bottom: 20px;
        }
        
        .highlight-name {
            font-weight: 600;
            color: #2d3748;
        }
        
        .intro-text {
            margin-bottom: 20px;
            font-size: 15px;
        }
        
        /* Task Section */
        .task-section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 17px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 12px;
        }
        
        .task-details {
            font-size: 14px;
            color: #4a5568;
            padding-left: 20px;
            margin: 0 0 0 10px;
        }
        
        .task-details li {
            margin-bottom: 8px;
            list-style-type: disc;
            padding-left: 5px;
        }
        
        .task-details strong {
            font-weight: 600;
        }
        
        /* Footer Sections */
        .closing-text {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 25px;
        }
        
        .creator-followers {
            margin: 20px 0;
            padding: 15px 0;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .creator-followers strong {
            font-weight: 600;
        }
        
        .signature {
            color: #38a169;
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .signature-text {
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 20px;
        }
        
        .footer {
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }
        
        /* Responsive Adjustments */
        @media screen and (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .email-content {
                padding: 8%;
                width: 84%;
            }
            
            .header {
                font-size: 20px;
            }
            
            .task-details {
                padding-left: 15px;
            }
        }
        
        @media screen and (max-width: 320px) {
            .email-content {
                padding: 6%;
                width: 88%;
            }
            
            .header {
                font-size: 18px;
            }
            
            .section-title {
                font-size: 16px;
            }
            
            .creator-followers {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-content">
            <h2 class="header">Task Reminder</h2>

            <p class="greeting">
                Hello <span class="highlight-name">{{ $task->creator->name }}</span>,
            </p>

            <p class="intro-text">
                Hope you're doing great! Just a friendly reminder about a task you created. Let's keep the energy up and
                collaborate to get things done effectively. 💪
            </p>

            <div class="task-section">
                <h3 class="section-title">Task Details:</h3>
                <ul class="task-details">
                    <li><strong>Title:</strong> {{ $task->title }}</li>
                    <li><strong>Description:</strong>{{ $task->description }}</li>
                    <li><strong>Assigned Date:</strong>{{ \Carbon\Carbon::parse($task->assigned_date)->format('F j, Y') }}</li>
                    <li><strong>Created At:</strong>{{ \Carbon\Carbon::parse($task->created_at)->format('F j, Y') }}</li>
                    <li><strong>Timezone:</strong> UTC</li>
                </ul>
            </div>

            <div>
                <p class="closing-text">
                    Let's stay focused and work together toward completing this task. Your teamwork makes a difference! If
                    you need any help or clarification, don't hesitate to reach out. 👍
                </p>
            </div>

            <div class="creator-followers">
                <strong>Created by:</strong> {{ $task->creator->name }}| 
                <strong>Followers:</strong>
                @foreach ($task->followers as $follower)
                   {{ $follower->name }}
                @endforeach
            </div>

            <p class="signature">Cheers,</p>
            <p class="signature-text">Your Productivity Assistant 💼</p>
        </div>

        <div class="footer">
            This is an automated reminder sent to {{ $task->creator->email }}
            @if ($task->followers->count())
                and CC'd to {{ $task->followers->count() }} follower{{ $task->followers->count() > 1 ? 's' : '' }}.
            @endif
        </div>
    </div>
</body>
</html>