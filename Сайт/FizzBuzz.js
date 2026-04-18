let num = prompt('Введите число')

if (num % 3 == 0 & num % 5 != 0 & num != 0) {
    alert('Fizz')
} else if (num % 5 == 0 & num % 3 != 0 & num != 0) {
    alert('Buzz')
} else if (num % 3 == 0 & num % 5 == 0 & num != 0) {
    alert('FizzBuzz')
} else {
    alert(num)
}