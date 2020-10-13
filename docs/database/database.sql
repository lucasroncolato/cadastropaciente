--
-- Banco de dados: `paciente`
--
CREATE DATABASE IF NOT EXISTS `paciente` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `paciente`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `customer`
--

CREATE TABLE `customer` (
  `id` int(9) UNSIGNED NOT NULL,
  `register` timestamp NOT NULL DEFAULT current_timestamp(),
  `cpf` char(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `birthday` date DEFAULT NULL,
  `convenio` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

