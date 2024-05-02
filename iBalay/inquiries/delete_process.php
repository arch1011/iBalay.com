<?php
	include './../connect_db/connection.php';

	if (isset($_GET['inquiryID'])) {
			$inquiryID = $_GET['inquiryID'];

			$fetchReplyIDQuery = "SELECT ReplyID FROM reply WHERE InquiryID = ?";
			$stmtFetchReplyID = mysqli_prepare($conn, $fetchReplyIDQuery);

			if ($stmtFetchReplyID) {
					mysqli_stmt_bind_param($stmtFetchReplyID, "i", $inquiryID);
					mysqli_stmt_execute($stmtFetchReplyID);
					mysqli_stmt_store_result($stmtFetchReplyID);

					if (mysqli_stmt_num_rows($stmtFetchReplyID) > 0) {
							mysqli_stmt_bind_result($stmtFetchReplyID, $replyID);
							$replyIDs = [];

							while (mysqli_stmt_fetch($stmtFetchReplyID)) {
									$replyIDs[] = $replyID;
							}
									$deleteRepliesQuery = "DELETE FROM reply WHERE ReplyID IN (" . implode(",", array_fill(0, count($replyIDs), "?")) . ")";
									$stmtDeleteReplies = mysqli_prepare($conn, $deleteRepliesQuery);

									if ($stmtDeleteReplies) {

											$bindParams = array_merge(["i"], $replyIDs); 
											call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmtDeleteReplies], $bindParams));

											mysqli_stmt_execute($stmtDeleteReplies);
											mysqli_stmt_close($stmtDeleteReplies);
									} else {
											die("Error deleting replies: " . mysqli_error($conn));
									}
													}
													mysqli_stmt_close($stmtFetchReplyID);
											} else {
													die("Error fetching ReplyIDs: " . mysqli_error($conn));
											}

											$deleteInquiryQuery = "DELETE FROM inquiry WHERE InquiryID = ?";
											$stmtDeleteInquiry = mysqli_prepare($conn, $deleteInquiryQuery);

												if ($stmtDeleteInquiry) {
														mysqli_stmt_bind_param($stmtDeleteInquiry, "i", $inquiryID);
														mysqli_stmt_execute($stmtDeleteInquiry);
														mysqli_stmt_close($stmtDeleteInquiry);
														header("Location: http://localhost/iBalay/inquiries/inquiry_page.php");
														exit();
												} else {
														die("Error deleting inquiry: " . mysqli_error($conn));
												}
										} else {
												echo "InquiryID is not set.";
										}
?>
