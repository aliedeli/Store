
Create Function Fn insertAccounts
(
    @AccountName nvarchar(50),
    @AccountType nvarchar(50),
    @AccountNumber nvarchar(50),
    @AccountBalance decimal(18,2),
    @AccountStatus nvarchar(50),
    @AccountOpenDate datetime,
    @AccountCloseDate datetime
)
Returns int
As
Begin
    Insert Into Accounts(AccountName, AccountType, AccountNumber, AccountBalance, AccountStatus, AccountOpenDate, AccountCloseDate)
    Values(@AccountName, @AccountType, @AccountNumber, @AccountBalance, @AccountStatus, @AccountOpenDate, @AccountCloseDate)

    Return @@Identity
End
Go

