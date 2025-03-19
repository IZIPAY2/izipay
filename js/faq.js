// Получаем все вопросы и ответы
const faqQuestions = document.querySelectorAll('.faq-question');

// Добавляем обработчик событий на каждый вопрос
faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
        // Находим ответ для этого вопроса
        const answer = question.nextElementSibling;

        // Если ответ уже открыт, скрываем его
        if (answer.classList.contains('show')) {
            answer.classList.remove('show');
        } else {
            // Скрываем все другие открытые ответы
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('show'));

            // Открываем текущий ответ
            answer.classList.add('show');
        }
    });
});
